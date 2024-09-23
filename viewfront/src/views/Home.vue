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
        <el-header>
            <el-menu :default-active="activeIndex" @select="handleSelect" class="el-menu-container">
                <div class="menu-left">
                    <el-menu-item index="/home">首页</el-menu-item>
                    <el-menu-item index="/blog">博文</el-menu-item>
                    <el-menu-item index="/category">分类</el-menu-item>
                    <el-menu-item index="/tools">导航</el-menu-item>
                    <el-menu-item index="/chat">聊天室</el-menu-item>
                    <el-menu-item index="/about">关于</el-menu-item>

<!--                    <el-menu-item index="/home">首页</el-menu-item>-->
<!--                    <el-menu-item index="/">博文</el-menu-item>-->
<!--                    <el-menu-item index="/">分类</el-menu-item>-->
<!--                    <el-menu-item index="/">工具</el-menu-item>-->
<!--                    <el-menu-item index="/">聊天室</el-menu-item>-->
<!--                    <el-menu-item index="/">关于</el-menu-item>-->
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
                    <el-card v-for="(blog, index) in articles" :key="index" class="blog-card">
                        <h2>{{ blog.title }}</h2>
                        <div class="demo-image__placeholder">
                            <div class="block">
                                <el-image :src="blog.coverImg" />
                            </div>
                        </div>
                        <el-button type="text"  @click="readArticle(index)">阅读全文</el-button>
                    </el-card>
                    <!-- 分页条 -->
                    <el-pagination v-model:current-page="pageNum" v-model:page-size="pageSize" :page-sizes="[3, 5, 10, 15]"
                                   layout="jumper, total, sizes, prev, pager, next" background :total="total" @size-change="onSizeChange"
                                   @current-change="onCurrentChange" style="margin-top: 20px; justify-content: flex-end" />
                </el-col>
                <el-col :span="8">
                    <el-card class="sidebar-card">
                        <h3>热门博文</h3>
                        <el-list>
                            <el-list-item v-for="(item, index) in popularBlogs" :key="index">
                               <h4> {{ item.title }}</h4>
                            </el-list-item>
                        </el-list>
                    </el-card>
                </el-col>
            </el-row>
        </el-main>
    </div>
</template>

<style scoped>
.demo-image__placeholder .block {
    text-align: center;
    border-right: solid 1px var(--el-border-color);
    display: inline-block;
    width: 25%;
    box-sizing: border-box;
    vertical-align: top;
}
.demo-image__placeholder .demonstration {
    display: block;
    color: var(--el-text-color-secondary);
    font-size: 14px;
    margin-bottom: 0px;
}
.demo-image__placeholder .el-image {
    max-width: 100%;
    max-height: 100%;
}

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
