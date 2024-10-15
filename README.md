# 一个简单的个人博客管理平台

## 前端技术栈

- vue3
- js
- html
- css
- element-plus

## 后端技术栈

- springboot
- redis
- mysql
- mybatis

## About界面

### 屏控1

![image-20241015151537667](assets/image-20241015151537667.png)

### 屏控2

![image-20241015151619452](assets/image-20241015151619452.png)

## 首页展示

![image-20240925200755102](assets/image-20240925200755102.png)

### 页面介绍

1. 左边为文章界面点击文字名字就能进行阅读

2. 右边为热门博客功能能够实时统计前五名博客热度并且将前三名展示在卡片中(卡片上的时间为该文章的创建时间)


### 功能介绍

- 允许检索内容和模糊搜素以及统计热度


![image-20240925201338084](assets/image-20240925201338084.png)

## 阅读器展示

![image-20240925201109628](assets/image-20240925201109628.png![image-20240925201842164](assets/image-20240925201842164.png)

分为目录和内容两部分

### 目录

- 目录可以用来检索到文章的指定位置


### 内容

- 内容由解析md文件得到同时右上角展示作者头像以及阅读量


## 导航页面

![image-20241015151416261](assets/image-20241015151416261.png)

- 用于快速到指定位置同时允许用google引擎进行搜索问题
- 其他card可以快速定位到指定路由


## 留言页面

![image-20240925201543080](assets/image-20240925201543080.png)

- 有星星闪烁，弹幕发送等功能


## 管理端页面展示

### 文章分类

![image-20240925201652768](assets/image-20240925201652768.png)

- 支持增删改查


### 文章管理

![image-20240925201710821](assets/image-20240925201710821.png)

- 支持搜索功能


### 个人中心

#### 基本资料

![image-20240925201752480](assets/image-20240925201752480.png)

#### 更换头像

![image-20240925201804606](assets/image-20240925201804606.png)

#### 重置密码

![image-20240925201821523](assets/image-20240925201821523.png)

### 编辑器

![image-20240925203351829](assets/image-20240925203351829.png)

#### 发布表单

![image-20240925203431253](assets/image-20240925203431253.png)

- 有小型阅读器



## html小游戏

按F5刷新游戏资源启动

### 游戏1

![image-20241015151123194](assets/image-20241015151123194.png)

- 空格变色颜色一样得分

### 游戏2

![image-20241015151145026](assets/image-20241015151145026.png)

- b键发射，血为0结束游戏



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

