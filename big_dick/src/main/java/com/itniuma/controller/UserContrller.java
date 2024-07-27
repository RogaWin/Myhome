package com.itniuma.controller;


import com.itniuma.pojo.Result;
import com.itniuma.pojo.User;
import com.itniuma.service.UserService;
import com.itniuma.utils.JwtUtil;
import com.itniuma.utils.Md5Util;
import com.itniuma.utils.ThreadLocalUtil;
import jakarta.validation.constraints.Pattern;
import org.hibernate.validator.constraints.URL;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.redis.core.StringRedisTemplate;
import org.springframework.data.redis.core.ValueOperations;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;

import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.TimeUnit;

@RestController
@RequestMapping(value = "/user")
@Validated
public class UserContrller {
    @Autowired
    private UserService userService;
    @Autowired
    private StringRedisTemplate stringRedisTemplate;

    @PostMapping(value = "/register")
    public Result register(@Pattern(regexp = "^\\S{5,16}$") String username, @Pattern(regexp = "^\\S{5,16}$") String password) {
        //查询用户
        User u = userService.findByUsername(username);
        if (u != null) {
            return Result.error("用户名已存在");
        } else {
            userService.register(username, password);
            return Result.success();
        }
    }

    @PostMapping(value = "/login")
    public Result login( String username, String password) {
        User loginUser = userService.findByUsername(username);
        //判断用户是否存在
        if (loginUser==null){
            return Result.error("用户名不存在");
        }
        //判断密码是否正确
        if(Md5Util.getMD5String(password).equals(loginUser.getPassword())){
            //登录成功
            Map<String,Object> claims = new HashMap<>();
            claims.put("id",loginUser.getId());
            claims.put("username",username);
            String token = JwtUtil.genToken(claims);
            //token存到redis中
            ValueOperations<String, String> operations = stringRedisTemplate.opsForValue();
            operations.set(token,token,1, TimeUnit.HOURS);
            return Result.success(token);
        }
        return Result.error("密码错误");
    }

    @GetMapping(value = "/userInfo")
    public Result<User> userInfo(){
        //根据用户名查询用户
//        Map<String, Object> map = JwtUtil.parseToken(token);
//        String username = (String) map.get("username");
        Map<String, Object> map = ThreadLocalUtil.get();
        String username = (String) map.get("username");
        User user = userService.findByUsername(username);
        return Result.success(user);
    }
    @PutMapping(value = "/update")
    public Result update(@RequestBody @Validated User user){
        userService.update(user);
        return Result.success();
    }

    @PatchMapping(value = "/updateAvatar")
    public Result updateAvatar(@RequestParam @URL String avatarUrl){
        userService.updateAvatar(avatarUrl);
        return Result.success();
    }

    @PatchMapping(value = "/updatePwd")
    public Result updatePwd(@RequestBody Map<String,String> params,@RequestHeader(value ="Authorization") String token){
        //校验参数
        String oldPwd = params.get("old_pwd");
        String newPwd = params.get("new_pwd");
        String rePwd = params.get("re_pwd");
        if(oldPwd==null||newPwd==null||rePwd==null){
            return Result.error("参数缺失");
        }
        //原密码是否正确
        Map<String,Object> map = ThreadLocalUtil.get();
        String username = (String) map.get("username");
        User loginUser = userService.findByUsername(username);
        //判断密码是否正确
        if(!Md5Util.getMD5String(oldPwd).equals(loginUser.getPassword())){
            return Result.error("原密码填写不正确");
        }
        //新密码是否一致
        if(!newPwd.equals(rePwd)){
            return Result.error("两次密码不一致");
        }
        //修改密码
        userService.updatePwd(newPwd);
        //更新完成后要删除Redis中token
        ValueOperations<String, String> operations = stringRedisTemplate.opsForValue();
        operations.getOperations().delete(token);
        return Result.success();
    }
}
