import {createRouter, createWebHistory} from 'vue-router'
import LoginVue from "@/views/Login.vue";
import LayoutVue from  "@/views/Layout.vue"
import ArticleCategoryVue from '@/views/article/ArticleCategory.vue'
import ArticleManageVue from '@/views/article/ArticleManage.vue'
import UserAvatarVue from '@/views/user/UserAvatar.vue'
import UserInfoVue from '@/views/user/UserInfo.vue'
import UserResetPasswordVue from '@/views/user/UserResetPassword.vue'
import Reader from '@/views/article/Reader.vue'
import Editor from '@/views/article/Editor.vue'
import Home from "@/views/Home.vue";
import Tool from "@/views/tool/Tool.vue";
import Message from "@/views/tool/Message.vue"
import Category from "@/views/category.vue";
import GameLayOut from "@/views/GameLayOut.vue";
import Jumper from "@/views/game/Jumper.vue";
import HanBoGo from "@/views/game/HanBoGo.vue";

//定义路由关系
const routes = [
    {
        path: '/',
        redirect: '/home'
    },
    {
        path: '/login',
        component: LoginVue

    },
    {
        path: '/game',
        component: GameLayOut,
        children: [
            {
                name: 'Jumper',
                path: '/game/Jumper',
                component: Jumper ,
            },
            {
                name: 'HanBoGo',
                path: '/game/HanBoGo',
                component: HanBoGo ,
            },

        ]
    },
    {
        path: '/layout',
        component: LayoutVue,
        children: [
            {
                name: 'ArticleCategory',
                path: '/article/category',
                component:ArticleCategoryVue,
            },
            {
                name: 'ArticleManage',
                path: '/article/manage',
                component:ArticleManageVue,
            },
            {
                name: 'UserInfo',
                path: '/user/info',
                component:UserInfoVue,
            },
            {
                name: 'UserAvatar',
                path: '/user/avatar',
                component:UserAvatarVue,
            },
            {
                name: 'UserResetPassword',
                path: '/user/resetPassword',
                component:UserResetPasswordVue,
            }
        ]
    },
    {
        name: 'Reader',
        path: '/article/reader',
        component: Reader,
    },
    {
        name: 'Editor',
        path: '/article/editor',
        component: Editor,
    },
    {
        name: 'Home',
        path: '/home',
        component: Home,
    },
    //添加工具组件
    {
        name: 'Tool',
        path: '/tools',
        component: Tool,
    },
    //添加about
    {
        name: 'About',
        path: '/about',
        component: () => import('@/views/about/About.vue'),
    },
    {
        name: 'Message',
        path: '/message',
        component: Message,
    },
    {
        name: 'Category',
        path: '/category',
        component: Category,
    },
]
//创建路由实例
const router = createRouter({
    routes: routes,
    history: createWebHistory(),
})
//导出
export default router
