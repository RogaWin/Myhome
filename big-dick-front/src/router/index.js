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



//定义路由关系
const routes = [
    {
        path: '/',
        redirect: '/layout'
    },
    {
        path: '/login',
        component: LoginVue

    },
    {
        path: '/layout',
        component: LayoutVue,
        children: [
            {
                path: '/article/category',
                component:ArticleCategoryVue,
            },
            {
                path: '/article/manage',
                component:ArticleManageVue,
            },
            {
                path: '/user/info',
                component:UserInfoVue,
            },
            {
                path: '/user/avatar',
                component:UserAvatarVue,
            },
            {
                path: '/user/resetPassword',
                component:UserResetPasswordVue,
            }
        ]
    },
    {
        path: '/article/reader',
        component: Reader,
    },
    {
        path: '/article/editor',
        component: Editor,
    },
]
//创建路由实例
const router = createRouter({
    routes: routes,
    history: createWebHistory(),
})
//导出
export default router
