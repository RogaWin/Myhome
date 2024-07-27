package com.itniuma.service;

import com.itniuma.pojo.User;

public interface UserService {
    //用户名查询
    User findByUsername(String username);
    //注册
    void register(String username, String password);
    //更新
    void update(User user);

    //更新头像
    void updateAvatar(String avatarUrl);

    void updatePwd(String newPwd);
}
