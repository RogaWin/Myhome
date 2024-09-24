package com.itniuma.controller;




import com.itniuma.pojo.Article;
import com.itniuma.pojo.PageBean;
import com.itniuma.pojo.Result;
import com.itniuma.service.ArticleService;
import com.itniuma.service.RedisService;
import com.itniuma.service.UserService;
import com.itniuma.utils.ThreadLocalUtil;
import io.swagger.annotations.ApiOperation;
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
    @Autowired
    private RedisService redisService;
    //添加文章
    @ApiOperation(value = "添加文章")
    @PostMapping
    public Result add(@RequestBody @Validated Article article){
        articleService.add(article);
        return Result.success();
    }
    //文章列表
    @ApiOperation(value = "文章列表")
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
    @ApiOperation(value = "更新文章")
    @PutMapping
    public Result update(@RequestBody @Validated Article article){
        articleService.update(article);
        return Result.success();
    }
    //删除文章
    @ApiOperation(value = "删除文章")
    @DeleteMapping
    public Result delete(Integer id){
        articleService.delete(id);
        return Result.success();
    }
    @ApiOperation(value = "获取文章详情")
    @GetMapping(value = "/detail")
    public Result<Article> detail(Integer id){
        Article article = articleService.findById(id);
        return Result.success(article);
    }

    @ApiOperation(value = "获取所有已经发布的文章列表")
    @GetMapping(value = "/listAll")
    public Result<PageBean<Article>> listAll(
            Integer pageNum,
            Integer pageSize,
            @RequestParam(required = false) String title
            )
    {
        PageBean pb = articleService.listAll(pageNum,pageSize,title);
        return Result.success(pb);
    }

    /**
     * 获取文章阅读量
     *
     * @param articleId 文章 ID
     * @return 阅读量
     */
    @GetMapping("/views")
    public Result getViews(@RequestParam(value = "id") Integer articleId) {
        return redisService.getArticleViews(articleId);
    }

    /**
     * 增加文章阅读量
     *
     * @param articleId 文章 ID
     * @return 更新后的阅读量
     */
    @Autowired
    private UserService userService;
    @PostMapping("/views")
    public Result addViews(@RequestParam(value = "id") Integer articleId) {
        Map<String, Object> map = ThreadLocalUtil.get();
        Integer userId = (Integer) map.get("id");
        // 检查用户是否已阅读过文章
        if (!redisService.hasUserReadArticle(articleId, userId)) {
            // 增加阅读量
            Integer views = redisService.incrementArticleViews(articleId);
            // 标记用户已阅读
            redisService.markUserAsReadArticle(articleId, userId);
            return Result.success(views);
        } else {
            return Result.error("用户已阅读过文章");
        }
    }
}
