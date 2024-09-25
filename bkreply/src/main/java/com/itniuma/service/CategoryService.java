package com.itniuma.service;

import com.itniuma.pojo.Category;

import java.util.List;

public interface CategoryService {


    void add(Category category);

    //查询所有
    List<Category> list();

    //根据id查询
    Category findById(Integer id);

    void update(Category category);

    void delete(Integer id);

    List<Category> listAll();
}
