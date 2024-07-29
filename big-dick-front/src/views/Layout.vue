<script setup>
import {
    Management,
    Promotion,
    UserFilled,
    User,
    Crop,
    EditPen,
    SwitchButton,
    CaretBottom
} from '@element-plus/icons-vue'
import avatar from '@/assets/default.png'

import { UserInfoService } from "@/api/user.js";
import useUserInfoStore from "@/stores/userinfo.js";
const userInfoStore = useUserInfoStore();

// 调用函数，获取用户详细信息
const getUserInfo = async () => {
    let result = await UserInfoService();
    // 数据存储到 Pinia 中
    userInfoStore.setInfo(result.data);
};
getUserInfo();

// 条目被点击后
import { useRouter } from "vue-router";
import { ElMessage, ElMessageBox } from "element-plus";
import { useTokenStore } from '@/stores/token.js';
const tokenStore = useTokenStore();
const router = useRouter();

// 处理上标签
const handleSelect = (index) => {
    if (index.startsWith('/')) {
        router.push(index);
    }
};

const handleCommand = (command) => {
    if (command === 'logout') {
        // 提示用户
        ElMessageBox.confirm(
            '您确认要退出吗',
            '温馨提示',
            {
                confirmButtonText: '确认',
                cancelButtonText: '取消',
                type: 'warning',
                center: true,
            }
        )
            .then(async () => {
                // 清空 token 和个人信息
                tokenStore.removeToken();
                userInfoStore.removeInfo();
                ElMessage({
                    type: 'success',
                    message: '退出登录成功',
                });
                await router.push('/home');
            })
            .catch(() => {
                ElMessage({
                    type: 'info',
                    message: '用户取消了退出登录',
                });
            });
    } else {
        router.push('/user/' + command);
    }
};
</script>

<template>
    <el-container class="layout-container">
        <!-- 左侧菜单 -->
        <el-aside width="200px">
            <div class="el-aside__logo"></div>
            <el-menu active-text-color="#ffd04b" background-color="#232323" text-color="#fff" router>
                <el-menu-item index="/article/category">
                    <el-icon>
                        <Management />
                    </el-icon>
                    <span>文章分类</span>
                </el-menu-item>
                <el-menu-item index="/article/manage">
                    <el-icon>
                        <Promotion />
                    </el-icon>
                    <span>文章管理</span>
                </el-menu-item>
                <el-sub-menu>
                    <template #title>
                        <el-icon>
                            <UserFilled />
                        </el-icon>
                        <span>个人中心</span>
                    </template>
                    <el-menu-item index="/user/info">
                        <el-icon>
                            <User />
                        </el-icon>
                        <span>基本资料</span>
                    </el-menu-item>
                    <el-menu-item index="/user/avatar">
                        <el-icon>
                            <Crop />
                        </el-icon>
                        <span>更换头像</span>
                    </el-menu-item>
                    <el-menu-item index="/user/resetPassword">
                        <el-icon>
                            <EditPen />
                        </el-icon>
                        <span>重置密码</span>
                    </el-menu-item>
                </el-sub-menu>
            </el-menu>
        </el-aside>
        <!-- 右侧主区域 -->
        <el-container>
            <!-- 头部区域 -->
            <el-header>
                <el-menu mode="horizontal" @select="handleSelect" class="el-menu-container" router>
                    <el-menu-item index="/home">首页</el-menu-item>
                    <el-menu-item index="/blog">博文</el-menu-item>
                    <el-menu-item index="/category">分类</el-menu-item>
                    <el-menu-item index="/tools">工具</el-menu-item>
                    <el-menu-item index="/chat">聊天室</el-menu-item>
                    <el-menu-item index="/about">关于</el-menu-item>
                </el-menu>

                <el-dropdown placement="bottom-end" @command="handleCommand">
          <span class="el-dropdown__box">
            <el-avatar :src="userInfoStore.info.userPic || avatar" />
            <el-icon>
              <CaretBottom />
            </el-icon>
          </span>
                    <template #dropdown>
                        <el-dropdown-menu>
                            <el-dropdown-item command="info" :icon="User">基本资料</el-dropdown-item>
                            <el-dropdown-item command="avatar" :icon="Crop">更换头像</el-dropdown-item>
                            <el-dropdown-item command="resetPassword" :icon="EditPen">重置密码</el-dropdown-item>
                            <el-dropdown-item command="logout" :icon="SwitchButton">退出登录</el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
                </el-dropdown>
            </el-header>
            <!-- 中间区域 -->
            <el-main>
                <router-view></router-view>
            </el-main>
            <!-- 底部区域 -->
            <el-footer>傻了莫 ©2024 Created by 牛牛</el-footer>
        </el-container>
    </el-container>
</template>

<style lang="scss" scoped>
.layout-container {
    height: 100vh;

    .el-aside {
        background-color: #232323;

        &__logo {
            height: 120px;
            background: url('@/assets/logo.png') no-repeat center / 120px auto;
        }

        .el-menu {
            border-right: none;
        }
    }

    .el-header {
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;

        .el-dropdown__box {
            display: flex;
            align-items: center;

            .el-icon {
                color: #999;
                margin-left: 10px;
            }

            &:active,
            &:focus {
                outline: none;
            }
        }
    }

    .el-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #666;
    }
}
</style>
