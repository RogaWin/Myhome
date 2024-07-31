<template>
    <div class="home-page">
        <el-header>
            <el-menu :default-active="activeIndex" @select="handleSelect" class="el-menu-container">
                <div class="menu-left">
                    <el-menu-item index="/home">首页</el-menu-item>
                    <el-menu-item index="/blog">博文</el-menu-item>
                    <el-menu-item index="/category">分类</el-menu-item>
                    <el-menu-item index="/tools">工具</el-menu-item>
                    <el-menu-item index="/chat">聊天室</el-menu-item>
                    <el-menu-item index="/about">关于</el-menu-item>
                    <el-menu-item>
                        <el-input v-model="keyword" class="search-input" placeholder="请输入" clearable />
                        <el-button :icon="Search" circle />
                    </el-menu-item>
                </div>
                <div class="menu-right">
                    <el-dropdown @command="handleCommand">
            <span class="el-dropdown__box">
              <el-avatar :src="userInfoStore.info.userPic || avatar" />
              <el-icon>
                <CaretBottom />
              </el-icon>
            </span>
                        <template #dropdown>
                            <div v-if="isUserLoggedIn">
                                <el-dropdown-menu>
                                    <el-dropdown-item command="info" :icon="User">基本资料</el-dropdown-item>
                                    <el-dropdown-item command="avatar" :icon="Crop">更换头像</el-dropdown-item>
                                    <el-dropdown-item command="manage" :icon="EditPen">内容管理</el-dropdown-item>
                                    <el-dropdown-item command="logout" :icon="SwitchButton">退出登录</el-dropdown-item>
                                </el-dropdown-menu>
                            </div>
                            <div v-else>
                                <el-popover placement="top-start" title="Tip:" :width="400" trigger="hover" content="登入后你可以发表文章">
                                    <template #reference>
                                        <el-card style="width: 100px">
                                            <el-button command="login" type="primary" round @click="router.push('/login')">登录</el-button>
                                        </el-card>
                                    </template>
                                </el-popover>
                            </div>
                        </template>
                    </el-dropdown>
                </div>
            </el-menu>
        </el-header>
        <el-main>
            <el-row :gutter="20">
                <el-col :span="16">
                    <el-card v-for="(blog, index) in blogs" :key="index" class="blog-card">
                        <h2>{{ blog.title }}</h2>
                        <p>{{ blog.summary }}</p>
                        <el-button type="text">阅读全文</el-button>
                    </el-card>
                    <el-pagination background layout="prev, pager, next" :total="totalBlogs" @current-change="handlePageChange"></el-pagination>
                </el-col>
                <el-col :span="8">
                    <el-card class="sidebar-card">
                        <h3>热门博文</h3>
                        <el-list>
                            <el-list-item v-for="(item, index) in popularBlogs" :key="index">
                                {{ item.title }}
                            </el-list-item>
                        </el-list>
                    </el-card>
                </el-col>
            </el-row>
        </el-main>
    </div>
</template>

<script>
import { ref } from 'vue';
import {CaretBottom, Crop, EditPen, SwitchButton, User} from "@element-plus/icons-vue";
import useUserInfoStore from "@/stores/userinfo.js";
import { ElMessage, ElMessageBox } from "element-plus";
import { useRouter } from "vue-router";
import { Search } from '@element-plus/icons-vue';
import { useTokenStore } from "@/stores/token.js";
import avatar from '@/assets/default.png';


export default {
    name: 'HomePage',
    computed: {
        SwitchButton() {
            return SwitchButton
        },
        EditPen() {
            return EditPen
        },
        Crop() {
            return Crop
        },
        User() {
            return User
        }
    },
    components: { CaretBottom },
    setup() {
        const tokenStore = useTokenStore();
        const userInfoStore = useUserInfoStore();
        const activeIndex = ref('1');
        const blogs = ref([
            { title: '博客标题1', summary: '博客摘要1' },
            { title: '博客标题2', summary: '博客摘要2' },
            { title: '博客标题3', summary: '博客摘要3' },
            // 更多博客数据
        ]);
        const popularBlogs = ref([
            { title: '热门博文1' },
            { title: '热门博文2' },
            { title: '热门博文3' },
            // 更多热门博文数据
        ]);
        const totalBlogs = ref(100);
        const keyword = ref('');

        let isUserLoggedIn = !!userInfoStore.info.userPic;

        const handleSelect = (command) => {
            router.push(command);
        };

        const handlePageChange = (page) => {
            console.log(`Page changed to ${page}`);
            // 这里可以添加代码来更新博客列表数据
        };

        const router = useRouter();
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
                        // 清空token和个人信息
                        await tokenStore.removeToken();
                        await userInfoStore.removeInfo();
                        ElMessage({
                            type: 'success',
                            message: '退出登录成功',
                        });
                        window.location.reload(); // 刷新页面
                        isUserLoggedIn = false;
                    })
                    .catch(() => {
                        ElMessage({
                            type: 'info',
                            message: '出错啦',
                        });
                    });
            }
            else if(command==="manage"){
                router.push('/article/' + command);
            }
            else {
                router.push('/user/' + command);
            }
        };

        return {
            router,
            isUserLoggedIn,
            keyword,
            userInfoStore,
            activeIndex,
            blogs,
            popularBlogs,
            totalBlogs,
            avatar,
            Search,
            CaretBottom, Crop, EditPen, SwitchButton, User,
            handleSelect,
            handleCommand,
            handlePageChange,
        };
    },
};
</script>

<style scoped>
.home-page {
    padding: 20px;
    background-color: #f0f2f5;
}

.el-menu-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.menu-left {
    display: flex;
    align-items: center;
}

.search-input {
    width: 240px;
    margin-left: 20px;
}

.menu-right {
    display: flex;
    align-items: center;
}

.el-dropdown__box {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.blog-card {
    margin-bottom: 20px;
}

.sidebar-card {
    margin-bottom: 20px;
}

.el-card h2 {
    font-size: 18px;
    margin: 0 0 10px;
}

.el-card p {
    font-size: 14px;
    color: #666;
}
</style>
