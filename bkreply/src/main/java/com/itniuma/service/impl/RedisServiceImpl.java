package com.itniuma.service.impl;

import com.itniuma.pojo.Result;
import com.itniuma.service.RedisService;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.RedisTemplate;
import org.springframework.stereotype.Service;

import java.util.concurrent.TimeUnit;

@Service
public class RedisServiceImpl implements RedisService {

    private static final Logger logger = LoggerFactory.getLogger(RedisServiceImpl.class);

    @Autowired
    private RedisTemplate<String, String> redisTemplate;

    // 定义 Redis 键的前缀
    private static final String ARTICLE_VIEWS_KEY = "article:views";
    private static final String ARTICLE_USERS_KEY_PREFIX = "article:%d:users";

    /**
     * 获取 Redis 中存储的文章阅读量的键名
     */
    private String getArticleViewsKey() {
        return ARTICLE_VIEWS_KEY;
    }

    /**
     * 获取某篇文章已阅读用户集合的键名
     */
    private String getArticleUsersKey(Integer articleId) {
        return String.format(ARTICLE_USERS_KEY_PREFIX, articleId);
    }

    /**
     * 获取文章阅读量
     *
     * @param articleId 文章 ID
     * @return 阅读量
     */
    @Override
    public Result getArticleViews(Integer articleId) {
        try {
            String articleIdStr = articleId.toString();
            Object result = redisTemplate.opsForHash().get(getArticleViewsKey(), articleIdStr);
            return result != null ? Result.success(result) : Result.error("文章不存在");
        } catch (Exception e) {
            logger.error("读取文章 {} 的阅读量失败", articleId, e);
            return Result.error("读取文章阅读量失败");
        }
    }

    /**
     * 增加文章阅读量
     *
     * @param articleId 文章 ID
     * @return 更新后的阅读量
     */
    @Override
    public Integer incrementArticleViews(Integer articleId) {
        try {
            String articleIdStr = articleId.toString();
            // 判断是否有这个键值对，如果没有就添加一个初始值 0 的键值对
            if (!redisTemplate.opsForHash().hasKey(getArticleViewsKey(), articleIdStr)) {
                redisTemplate.opsForHash().put(getArticleViewsKey(), articleIdStr, "0");
            }
            return redisTemplate.opsForHash()
                    .increment(getArticleViewsKey(), articleIdStr, 1)
                    .intValue();
        } catch (Exception e) {
            logger.error("增加文章 {} 的阅读量失败", articleId, e);
            throw new RuntimeException("增加文章阅读量失败", e);
        }
    }

    /**
     * 判断用户是否已阅读过文章
     *
     * @param articleId 文章 ID
     * @param userId    用户 ID
     * @return 是否已阅读
     */
    @Override
    public boolean hasUserReadArticle(Integer articleId, Integer userId) {
        String userKey = getArticleUsersKey(articleId);
        try {
            return Boolean.TRUE.equals(redisTemplate.opsForSet().isMember(userKey, userId.toString()));
        } catch (Exception e) {
            logger.error("检查用户 {} 是否已阅读文章 {} 失败", userId, articleId, e);
            throw new RuntimeException("检查用户阅读记录失败", e);
        }
    }

    /**
     * 将用户添加到已阅读文章的集合中
     *
     * @param articleId 文章 ID
     * @param userId    用户 ID
     */
    @Override
    public void markUserAsReadArticle(Integer articleId, Integer userId) {
        String userKey = getArticleUsersKey(articleId);
        try {
            redisTemplate.opsForSet().add(userKey, userId.toString());
            redisTemplate.expire(userKey, 30, TimeUnit.DAYS); // 设置用户阅读记录的过期时间
        } catch (Exception e) {
            logger.error("标记用户 {} 已阅读文章 {} 失败", userId, articleId, e);
            throw new RuntimeException("标记用户已阅读文章失败", e);
        }
    }
}
