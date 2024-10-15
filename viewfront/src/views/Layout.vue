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
} from '@element-plus/icons-vue';
import avatar from '@/assets/default.png';

import { UserInfoService } from "@/api/user.js";
import useUserInfoStore from "@/stores/userinfo.js";
const userInfoStore = useUserInfoStore();

// 使用 async/await 调用异步函数并捕获错误
const getUserInfo = async () => {
    try {
        let result = await UserInfoService();
        userInfoStore.setInfo(result.data); // 数据存储到 Pinia 中
    } catch (error) {
        console.error("获取用户信息失败:", error);
    }
};
getUserInfo();

import { useRouter } from "vue-router";
import { ElMessage, ElMessageBox } from "element-plus";
import { useTokenStore } from '@/stores/token.js';
const tokenStore = useTokenStore();
const router = useRouter();

const handleSelect = (index) => {
    if (index.startsWith('/')) {
        router.push(index);
    }
};

const handleCommand = (command) => {
    if (command === 'logout') {
        ElMessageBox.confirm(
            '您确认要退出吗？',
            '温馨提示',
            {
                confirmButtonText: '确认',
                cancelButtonText: '取消',
                type: 'warning',
                center: true,
            }
        )
            .then(async () => {
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
            <el-menu active-text-color="#2D629C" background-color="#232323" text-color="#005" router>
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
                        <span class="submenu-title">个人中心</span>
                    </template>
                    <el-menu-item index="/user/info">
                        <el-icon>
                            <User />
                        </el-icon>
                        <span class="submenu-item">基本资料</span>
                    </el-menu-item>
                    <el-menu-item index="/user/avatar">
                        <el-icon>
                            <Crop />
                        </el-icon>
                        <span class="submenu-item">更换头像</span>
                    </el-menu-item>
                    <el-menu-item index="/user/resetPassword">
                        <el-icon>
                            <EditPen />
                        </el-icon>
                        <span class="submenu-item">重置密码</span>
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
                    <el-menu-item index="/tools">导航</el-menu-item>
                    <el-menu-item index="/article/category">分类</el-menu-item>
                    <el-menu-item index="/article/manage">博文</el-menu-item>
                    <el-menu-item index="/game">游戏</el-menu-item>
                    <el-menu-item index="/message">留言</el-menu-item>
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
.submenu-title {
    color: #00aaff; // 个人中心标题颜色
}

.submenu-item {
    color:  #00aaff; // 子菜单项默认颜色
    transition: color 0.3s;

    &:hover {
        color: #00aaff; // 悬停时的颜色
        background: rgba(0, 170, 255, 0.1); // 悬停背景颜色
    }
}
.el-sub-menu__title{
    color: #00aaff;
    background-color: #00aaff;
}
.el-menu-item{
    color: #00aaff;
}
.layout-container {
    height: 100vh;

    // 背景改为蓝白偏黑
    background: linear-gradient(135deg, #0e4c92, #ffffff); // 深蓝与白色渐变

    .el-aside {
        background: rgba(255, 255, 255, 0.9); // 半透明白色背景
        box-shadow: 2px 0 12px rgba(0, 0, 0, 0.3); // 稍微加重阴影

        &__logo {
            height: 120px;
            background: url('@/assets/logo.png') no-repeat center / 120px auto;
        }

        .el-menu {
            border-right: none;
            background-color: transparent; // 清除菜单默认背景
            text-color: #333; // 字体颜色

            .el-menu-item,
            .el-sub-menu__title {
                transition: all 0.3s ease-in-out;

                &:hover {
                    background: rgba(0, 170, 255, 0.4); // 悬停时背景颜色更明显
                }
            }
        }
    }

    .el-header {
        background-color: rgba(255, 255, 255, 0.9); // 半透明白色背景
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;

        .el-menu {
            background-color: transparent;

            .el-menu-item {
                font-weight: bold; // 字体加粗
                color: #333;

                &:hover {
                    color: #0e4c92; // 悬停时的颜色改为深蓝
                }
            }
        }

        .el-dropdown__box {
            display: flex;
            align-items: center;

            .el-icon {
                color: #666;
                margin-left: 10px;
                transition: color 0.3s ease;

                &:hover {
                    color: #0e4c92; // 悬停时颜色变化
                }
            }

            &:active,
            &:focus {
                outline: none;
            }
        }
    }

    .el-main {
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8); // 半透明背景
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
        border-radius: 8px; // 边角圆润
        margin: 20px;
    }

    .el-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #666;
        background: rgba(255, 255, 255, 0.9); // 半透明白色背景
        padding: 10px;
        border-radius: 4px;
    }
}
</style>
