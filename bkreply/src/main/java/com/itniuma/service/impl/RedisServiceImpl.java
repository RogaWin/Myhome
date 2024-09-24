package com.itniuma.service.impl;

import com.itniuma.pojo.Result;
import com.itniuma.service.RedisService;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.StringRedisTemplate;
import org.springframework.stereotype.Service;

import java.util.*;
import java.util.stream.Collectors;

@Service
public class RedisServiceImpl implements RedisService {

    private static final Logger logger = LoggerFactory.getLogger(RedisServiceImpl.class);

    @Autowired
    private StringRedisTemplate redisTemplate;

    // 定义 Redis 键的前缀
    private static final String ARTICLE_VIEWS_KEY = "article:views:";

    // 获取 Redis 中存储的文章阅读量的键名
    private String getArticleViewsKey(Integer articleId) {
        return ARTICLE_VIEWS_KEY + articleId;
    }

    @Override
    public Result getArticleViews(Integer articleId) {
        try {
            Integer views = Optional.ofNullable(redisTemplate.opsForValue().get(getArticleViewsKey(articleId)))
                    .map(Integer::valueOf)
                    .orElse(0);
            return Result.success(views);
        } catch (Exception e) {
            logger.error("读取文章 {} 的阅读量失败", articleId, e);
            return Result.error("读取文章阅读量失败");
        }
    }

    @Override
    public Integer incrementArticleViews(Integer articleId) {
        try {
            String key = getArticleViewsKey(articleId);
            if (Boolean.FALSE.equals(redisTemplate.hasKey(key))) {
                redisTemplate.opsForValue().set(key, "0");
            }
            return Optional.ofNullable(redisTemplate.opsForValue().increment(key, 1))
                    .orElseThrow(() -> new RuntimeException("增加文章阅读量失败"))
                    .intValue();
        } catch (Exception e) {
            logger.error("增加文章 {} 的阅读量失败", articleId, e);
            throw new RuntimeException("增加文章阅读量失败", e);
        }
    }

    @Override
    public List<Integer> listTop5() {
        try {
            // 使用 Redis 的 keys 命令获取所有阅读量的键
            Set<String> keys = redisTemplate.keys(ARTICLE_VIEWS_KEY + "*");
            if (keys == null || keys.isEmpty()) {
                return new ArrayList<>();
            }

            // 批量获取这些键的值
            List<String> values = redisTemplate.opsForValue().multiGet(keys);
            if (values == null) {
                return new ArrayList<>();
            }

            // 创建一个键值对的集合
            Map<Integer, Integer> articleViewsMap = new HashMap<>();
            int index = 0;
            for (String key : keys) {
                Integer articleId = Integer.valueOf(key.replace(ARTICLE_VIEWS_KEY, ""));
                Integer views = Integer.valueOf(values.get(index++));
                articleViewsMap.put(articleId, views);
            }

            // 按照阅读量排序，取前五篇文章的 ID
            return articleViewsMap.entrySet().stream()
                    .sorted((entry1, entry2) -> entry2.getValue().compareTo(entry1.getValue()))
                    .limit(5)
                    .map(Map.Entry::getKey)
                    .collect(Collectors.toList());

        } catch (Exception e) {
            logger.error("获取前五篇阅读量最高的文章失败", e);
            throw new RuntimeException("获取前五篇阅读量最高的文章失败", e);
        }
    }
}
