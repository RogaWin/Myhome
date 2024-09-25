package com.itniuma.controller;


import com.itniuma.pojo.Category;
import com.itniuma.pojo.Result;
import com.itniuma.service.CategoryService;
import org.apache.ibatis.annotations.Delete;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping(value = "/category")
public class CategoryController {
    @Autowired
    private CategoryService categoryService;
    @PostMapping
    public Result add(@RequestBody @Validated(Category.Add.class) Category category) {
        categoryService.add(category);
        return Result.success();
    }

    @GetMapping
    public Result<List<Category>> list() {
        List<Category> cs = categoryService.list();
        return Result.success(cs);
    }


    @GetMapping(value = "/listAll")
    public Result<List<Category>> listAll() {
        List<Category> cs = categoryService.listAll();
        return Result.success(cs);
    }

    @GetMapping(value = "/detail")
    public Result<Category> detail(Integer id) {
        Category category = categoryService.findById(id);
        return Result.success(category);
    }

    @PutMapping
    public Result update(@RequestBody @Validated(Category.Update.class) Category category) {
        categoryService.update(category);
        return Result.success();
    }

    @DeleteMapping
    public Result delete(@RequestParam(required = true) Integer id) {
        categoryService.delete(id);
        return Result.success();
    }
}
