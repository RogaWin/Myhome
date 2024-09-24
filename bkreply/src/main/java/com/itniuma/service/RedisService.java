package com.itniuma.service;

import com.itniuma.pojo.Result;

import java.util.List;

public interface RedisService {
    Result getArticleViews(Integer articleId);


    Integer incrementArticleViews(Integer articleId);

    List<Integer> listTop5();

//    void markUserAsReadArticle(Integer articleId, Integer userId);

//    boolean hasUserReadArticle(Integer articleId, Integer userId);
}
