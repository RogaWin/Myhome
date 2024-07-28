package com.itniuma.controller;


import com.itniuma.pojo.Article;
import com.itniuma.pojo.PageBean;
import com.itniuma.pojo.Result;
import com.itniuma.service.ArticleService;
import com.itniuma.utils.JwtUtil;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;

import java.util.Map;

@RestController
@RequestMapping(value = "/article")
public class ArticleController {
//    @GetMapping(value = "/list")
//    public Result<String> list(@RequestHeader(name = "Authorization") String token, HttpServletResponse response){
////        //验证token
////        try {
////            Map<String, Object> claims = JwtUtil.parseToken(token);
////            return Result.success("所有的文章数据......");
////        } catch (Exception e) {
////            response.setStatus(401);
////            return Result.error("token失效");
////        }
//        return Result.success("所有的文章数据......");
//    }
//

    @Autowired
    private ArticleService articleService;

    //添加文章
    @PostMapping
    public Result add(@RequestBody @Validated Article article){
        articleService.add(article);
        return Result.success();
    }
    //文章列表
    @GetMapping
    public Result<PageBean<Article>> list(
        Integer pageNum,
        Integer pageSize,
        @RequestParam(required = false) Integer categoryId,
        @RequestParam(required = false) String state,
        @RequestParam(required = false) String title
    ){
        PageBean pb = articleService.list(pageNum,pageSize,categoryId,state,title);
        return Result.success(pb);
    }

    //更新文章
    @PutMapping
    public Result update(@RequestBody @Validated Article article){
        articleService.update(article);
        return Result.success();
    }
    //删除文章
    @DeleteMapping
    public Result delete(Integer id){
        articleService.delete(id);
        return Result.success();
    }
    //文章详细
    @GetMapping(value = "/detail")
    public Result<Article> detail(Integer id){
        Article article = articleService.findById(id);
        return Result.success(article);
    }
}
