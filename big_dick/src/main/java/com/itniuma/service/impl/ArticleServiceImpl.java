package com.itniuma.service.impl;



import com.github.pagehelper.Page;
import com.github.pagehelper.PageHelper;
import com.itniuma.mapper.ArticleMapper;
import com.itniuma.pojo.Article;
import com.itniuma.pojo.PageBean;
import com.itniuma.service.ArticleService;
import com.itniuma.utils.ThreadLocalUtil;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Map;

@Service
public class ArticleServiceImpl implements ArticleService {
    @Autowired
    private ArticleMapper articleMapper;
    @Override
    public void add(Article article) {
        article.setCreateTime(LocalDateTime.now());
        article.setUpdateTime(LocalDateTime.now());
        Map<String, Object> map = ThreadLocalUtil.get();
        Integer userId = (Integer) map.get("id");
        article.setCreateUser(userId);
        articleMapper.add(article);
    }

//    @Override
//    public PageBean list(Integer pageNum, Integer pageSize, Integer categoryId, String state) {
//        //创建page-bean对象
//        PageBean<Article> pb = new PageBean<>();
//
//        //开启分页查询
//        Map<String,Object> map = ThreadLocalUtil.get();
//        Integer userId = (Integer) map.get("id");
//
//        //调用mapper
//        articleMapper.List(userId,categoryId,state);
//        List<Article> as = articleMapper.List(userId,categoryId,state);
//        //page中提供了方法，可以获取PageHelper分页查询后，得到的总记录条数和当前页数量
//        PageHelper.startPage(pageNum,pageSize);
//        Page<Article> p = (Page<Article>) as;
//        //填充到PageBean
//        pb.setTotal(p.getTotal());
//        pb.setItems(p.getResult());
//        return pb;
//    }
    @Override
    public PageBean list(Integer pageNum, Integer pageSize, Integer categoryId, String state) {
        // 创建page-bean对象
        PageBean<Article> pb = new PageBean<>();

        // 开启分页查询
        Map<String, Object> map = ThreadLocalUtil.get();
        Integer userId = (Integer) map.get("id");

        // 分页查询之前开启分页
        PageHelper.startPage(pageNum, pageSize);

        // 调用mapper进行查询
        List<Article> as = articleMapper.List(userId, categoryId, state);

        // 确保返回的是分页结果
        Page<Article> p = (Page<Article>) as;

        // 填充到PageBean
        pb.setTotal(p.getTotal());
        pb.setItems(p.getResult());
        return pb;
    }

    @Override
    public void update(Article article) {
        article.setUpdateTime(LocalDateTime.now());
        articleMapper.update(article);
    }

    @Override
    public void delete(Integer id) {
        articleMapper.delete(id);
    }

    @Override
    public Article findById(Integer id) {
        return articleMapper.findById(id);
    }

}
