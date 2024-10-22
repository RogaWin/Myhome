package com.itniuma.service;

import com.itniuma.pojo.Article;
import com.itniuma.pojo.PageBean;

import java.util.List;


public interface ArticleService{
    //添加
    void add(Article article);

    //分页查询
    PageBean list(Integer pageNum, Integer pageSize, Integer categoryId, String state,String title);

    void update(Article article);

    void delete(Integer id);

    Article findById(Integer id);


    PageBean listAll(Integer pageNum, Integer pageSize, String title, List<Integer> categoryId);


    List<Article> listTop5();
}
