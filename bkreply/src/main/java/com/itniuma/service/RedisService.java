package com.itniuma.service;

import com.itniuma.pojo.Result;

public interface RedisService {
    Result getArticleViews(Integer articleId);

    boolean hasUserReadArticle(Integer articleId, Integer userId);

    Integer incrementArticleViews(Integer articleId);

    void markUserAsReadArticle(Integer articleId, Integer userId);
}
