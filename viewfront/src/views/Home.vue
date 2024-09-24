<script>
import { onMounted, ref } from 'vue';
import {CaretBottom, Crop, EditPen, Search, SwitchButton, User} from "@element-plus/icons-vue";
import useUserInfoStore from "@/stores/userinfo.js";
import { ElMessage, ElMessageBox } from "element-plus";
import { useRouter } from "vue-router";
import { useTokenStore } from "@/stores/token.js";
import avatar from '@/assets/default.png';
import { articleListAllService } from "@/api/article.js";
import {useArticleStore} from "@/stores/article.js";

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
        }
    },
    components: { CaretBottom, User },
    setup() {
        //文章分类数据模型
        const categorys = ref([]);
        //用户搜索时选中的分类id
        const categoryId = ref('');
        //用户搜索时选中的发布状态
        const state = ref('');
        //文章列表数据模型
        const articles = ref([]);
        const pageNum = ref(1); //当前页
        const total = ref(20); //总条数
        const pageSize = ref(3); //每页条数
        const tokenStore = useTokenStore();
        const userInfoStore = useUserInfoStore();
        const activeIndex = ref('1');
        const blogs = ref([
            { title: '博客标题1', imgUrl: 'https://big-big-dick.oss-cn-shenzhen.aliyuncs.com/39ff9020-ea5a-4d2d-bc36-ed37ae192ee9.jpg' },
            { title: '博客标题2', imgUrl: 'https://big-big-dick.oss-cn-shenzhen.aliyuncs.com/39ff9020-ea5a-4d2d-bc36-ed37ae192ee9.jpg' },
            { title: '博客标题3', imgUrl: 'https://big-big-dick.oss-cn-shenzhen.aliyuncs.com/39ff9020-ea5a-4d2d-bc36-ed37ae192ee9.jpg' },
            // 更多博客数据
        ]);
        const popularBlogs = ref([
            { title: '牛爷爷的爱情故事' },
            { title: '牛魔王前传' },
            { title: '大角牛勇敢向前' },
            // 更多热门博文数据
        ]);
        const totalBlogs = ref(100);
        const keyword = ref('');

        let isUserLoggedIn = userInfoStore.info.userPic!=null;

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
                        isUserLoggedIn = false;
                        window.location.reload(); // 刷新页面

                    })
                    .catch(() => {
                        ElMessage({
                            type: 'info',
                            message: '出错啦',
                        });
                    });
            } else if (command === "manage") {
                router.push('/article/' + command);
            } else {
                router.push('/user/' + command);
            }
        };

        const articleListAll = async () => {
            //关键字搜索
            let params = {
                pageNum: pageNum.value,
                pageSize: pageSize.value,
                title: keyword.value ? keyword.value : null
            };
            let result = await articleListAllService(params);
            console.log(result);
            //渲染视图
            total.value = result.data.total;
            articles.value = result.data.items;
            for (let i = 0; i < articles.value.length; i++) {
                let article = articles.value[i];
                for (let j = 0; j < categorys.value.length; j++) {
                    if (article.categoryId === categorys.value[j].id) {
                        article.categoryName = categorys.value[j].categoryName;
                    }
                }
            }
        };

        const onSizeChange = (size) => {
            pageSize.value = size;
            articleListAll();
        };

        //当前页码发生变化，调用此函数
        const onCurrentChange = (num) => {
            pageNum.value = num;
            articleListAll();
        };

        onMounted(() => {
            articleListAll();
        });

        const articleStore = useArticleStore();
        const readArticle = (index) => {
            console.log(index)
            articleStore.setArticle(articles.value[index])
            console.log(articleStore.article)
            router.push('/article/reader');
        };
        return {
            categorys,
            categoryId,
            state,
            articles,
            pageNum,
            total,
            pageSize,
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
            CaretBottom, User,
            handleSelect,
            handleCommand,
            handlePageChange,
            articleListAll,
            onSizeChange,
            onCurrentChange,
            readArticle
        };
    },
};
</script>

<template>
    <div class="home-page">
        <el-header class="header-container">
            <el-menu :default-active="activeIndex" @select="handleSelect" class="el-menu-container">
                <div class="menu-left">
                    <el-menu-item index="/home">首页</el-menu-item>
                    <el-menu-item index="/tools">导航</el-menu-item>
                    <el-menu-item index="/category">分类</el-menu-item>
                    <el-menu-item index="/blog">博文</el-menu-item>
                    <el-menu-item index="/chat">聊天室</el-menu-item>
                    <el-menu-item index="/about">关于</el-menu-item>
                    <el-menu-item>
                        <el-input v-model="keyword" class="search-input" placeholder="请输入" clearable />
                        <el-button :icon="Search" circle @click="articleListAll()" />
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
                    <el-card v-for="(blog, index) in articles" :key="index" class="blog-card animated-card" style="margin-bottom: 20px;">
                        <!-- 使用flex布局将图片和内容分成左右两部分 -->
                        <div class="blog-container" style="display: flex; align-items: center;">
                            <!-- 左侧图片部分 -->
                            <div style="flex-shrink: 0;">
                                <el-image :src="blog.coverImg" class="blog-image" style="width: 150px; height: 100px; object-fit: cover;" />
                            </div>
                            <!-- 右侧内容部分 -->
                            <div class="blog-content" style="flex-grow: 1; margin-left: 20px;">
                                <el-button type="text" class="read-more-btn" @click="readArticle(index)">
                                    <h2 class="blog-title" style="font-size: 20px; font-weight: bold;">{{ blog.title }}</h2>
                                </el-button>
                                <p class="blog-summary">
                                    {{ blog.introduction }}
                                </p>
                            </div>
                        </div>
                    </el-card>
                    <!-- 分页条 -->
                    <el-pagination v-model:current-page="pageNum" v-model:page-size="pageSize" :page-sizes="[3, 5, 10, 15]"
                                   layout="jumper, total, sizes, prev, pager, next" background :total="total" @size-change="onSizeChange"
                                   @current-change="onCurrentChange" class="pagination-bar" />
                </el-col>
                <el-col :span="8">
                    <el-card class="sidebar-card animated-sidebar">
                        <h3 class="sidebar-title">热门博文</h3>
                        <el-list class="popular-blogs-list">
                            <el-list-item v-for="(item, index) in popularBlogs" :key="index" class="popular-blog-item">
                                <h4 class="popular-blog-title">{{ item.title }}</h4>
                            </el-list-item>
                        </el-list>
                    </el-card>
                </el-col>
            </el-row>
        </el-main>
    </div>
</template>

<style scoped>

.blog-summary{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #6a7070;
}
.home-page {
    background: linear-gradient(to right, #1e3c72, #2a5298);
    padding: 20px;
    min-height: 100vh;
}
.header-container {
    background: #212121;
    border-bottom: 2px solid #ffffff33;
}
.el-menu-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 30px;
}
.menu-left, .menu-right {
    display: flex;
    align-items: center;
}
.menu-left .el-menu-item, .menu-right .el-menu-item {
    /*改为灰色*/
    color: #5b5656;
    transition: all 0.3s ease;
}
.menu-left .el-menu-item:hover {
    color: #00adb5;
    background-color: transparent;
}
.search-input {
    width: 200px;
    margin-right: 10px;
}
.blog-card {
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
}
.blog-title {
    color: #ffffff;
    font-size: 1.5em;

    /* 去掉默认下划线 */
    text-decoration: none;

    /* 聚焦时显示下划线 */
    &:focus {
        text-decoration: underline;
    }
}

.blog-image {
    border-radius: 10px;
/*    固定*/
    width: 250px;
/*    固定长度*/
    height: 150px;
}
.read-more-btn {
    color: #00adb5;
}
.pagination-bar {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}
.sidebar-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    border: none;
    padding: 20px;
    color: #ffffff;
    transition: all 0.3s ease;
}
.sidebar-title {
    color: #ffffff;
    font-size: 1.2em;
}
.popular-blogs-list {
    margin-top: 10px;
}
.popular-blog-item {
    border-bottom: 1px solid #ffffff33;
    padding: 10px 0;
}
.popular-blog-title {
    color: #00adb5;
}
.animated-card {
    animation: fadeInUp 0.5s ease-in-out;
}
.animated-sidebar {
    animation: fadeInRight 0.5s ease-in-out;
}

/* 自定义动画 */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
@keyframes fadeInRight {
    0% {
        opacity: 0;
        transform: translateX(-20px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}
</style>
