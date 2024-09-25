# 一个简单的个人博客管理平台

## 首页展示

![image-20240925200755102](assets/image-20240925200755102.png)

### 页面介绍

左边为文章界面点击文字名字就能进行阅读

右边为热门博客功能能够实时统计前五名博客热度并且将前三名展示在卡片中(卡片上的时间为该文章的创建时间)

### 功能介绍

允许检索内容和模糊搜素以及统计热度

![image-20240925201338084](assets/image-20240925201338084.png)

## 阅读器展示

![image-20240925201109628](assets/image-20240925201109628.png![image-20240925201842164](assets/image-20240925201842164.png)

分为目录和内容两部分

### 目录

目录可以用来检索到文章的指定位置

### 内容

内容由解析md文件得到同时右上角展示作者头像以及阅读量

## 导航页面

![image-20240925201411478](assets/image-20240925201411478.png)

用于快速到指定位置同时允许用google引擎进行搜索问题

## 留言页面

![image-20240925201543080](assets/image-20240925201543080.png)

有星星闪烁，弹幕发送登功能

## 管理端页面展示

### 文章分类

![image-20240925201652768](assets/image-20240925201652768.png)

支持增删改查

### 文章管理

![image-20240925201710821](assets/image-20240925201710821.png)

支持搜索功能

### 个人中心

#### 基本资料

![image-20240925201752480](assets/image-20240925201752480.png)

#### 更换头像

![image-20240925201804606](assets/image-20240925201804606.png)

#### 重置密码

![image-20240925201821523](assets/image-20240925201821523.png)

### 编辑器器

![image-20240925201722154](assets/image-20240925201722154.png)

# 环境

## 后端环境

**.yaml文件**

```yaml
spring:
  datasource:
    driver-class-name: com.mysql.cj.jdbc.Driver
    url: jdbc:mysql:// localhost:3306/myhome
    username: root
    password: 123456

  data:
    redis:
      host: localhost
      port: 6379
server:
  port: 8080

mybatis:
  configuration:
    map-underscore-to-camel-case: true

logging:
  level:
    sql: debug
#    root: debug


```

## 前端环境

```sh
npm install
```

# 友情链接

------

[弹幕组件]: https://github.com/hellodigua/vue-danmaku

