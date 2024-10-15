-- 创建数据库
create database myhome;

-- auto-generated definition
create table user
(
    id          int unsigned auto_increment comment 'ID'
        primary key,
    username    varchar(20)             not null comment '用户名',
    password    varchar(32)             null comment '密码',
    nickname    varchar(10)  default '' null comment '昵称',
    email       varchar(128) default '' null comment '邮箱',
    user_pic    varchar(128) default '' null comment '头像',
    create_time datetime                not null comment '创建时间',
    update_time datetime                not null comment '修改时间',
    constraint username
        unique (username)
)
    comment '用户表';
create table category
(
    id             int unsigned auto_increment comment 'ID'
        primary key,
    category_name  varchar(32)  not null comment '分类名称',
    category_alias varchar(32)  not null comment '分类别名',
    create_user    int unsigned not null comment '创建人ID',
    create_time    datetime     not null comment '创建时间',
    update_time    datetime     not null comment '修改时间',
    constraint fk_category_user
        foreign key (create_user) references user (id)
);
create table article
(
    id           bigint auto_increment comment 'ID'
        primary key,
    title        varchar(30)               not null comment '文章标题',
    content      varchar(10000)            not null comment '文章内容',
    cover_img    varchar(128)              not null comment '文章封面',
    state        varchar(3) default '草稿' null comment '文章状态: 只能是[已发布] 或者 [草稿]',
    category_id  int unsigned              null comment '文章分类ID',
    create_user  int unsigned              not null comment '创建人ID',
    create_time  datetime                  not null comment '创建时间',
    update_time  datetime                  not null comment '修改时间',
    introduction varchar(255)              null,
    constraint fk_article_category
        foreign key (category_id) references category (id),
    constraint fk_article_user
        foreign key (create_user) references user (id)
);



create table messages
(
    id           bigint auto_increment
        primary key,
    img          varchar(255)                       not null,
    content      text                               not null,
    created_time datetime default CURRENT_TIMESTAMP null
)
    collate = utf8mb4_general_ci;
