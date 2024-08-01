package com.itniuma.mapper;

import com.itniuma.pojo.Article;
import org.apache.ibatis.annotations.*;

import java.util.List;

@Mapper
public interface ArticleMapper {
    @Insert("insert into article(title,content,cover_img,state,category_id,create_user,create_time,update_time)" +
            "values(#{title},#{content},#{coverImg},#{state},#{categoryId},#{createUser},#{createTime},#{updateTime})")
    void add(Article article);


    List<Article> List(Integer userId, Integer categoryId, String state, String title);


    @Update("update article set title = #{title}, content = #{content}, cover_img = #{coverImg}, state = #{state}, category_id = #{categoryId}, update_time = #{updateTime} where id = #{id}")
    void update(Article article);

    // 删除
    @Delete("delete from article where id = #{id}")
    void delete(Integer id);

    @Select("select id, title, content, cover_img, state, category_id, create_user, create_time, update_time from article where id = #{id}")
    Article findById(Integer id);

    List<Article> ListAll(String title);
}
