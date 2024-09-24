<template>
    <div>
        <div class="common-layout">
            <el-container>
                <el-aside width="250px" class="fixed-section">
                    <el-scrollbar class="scrollbar-demo-item">
                        <span class="content-title">目录</span>
                        <MdCatalog :editorId="id" :scrollElement="scrollElement" @clickTitle="handleClickTitle"/>
                    </el-scrollbar>
                </el-aside>
                <el-main class="main-section">
                    <header class="content-header">
                        <h1 class="content-title">内容</h1> <!-- 内容标题 -->
                        <div class="author-info">
                            <el-avatar :src="authorAvatar" class="author-avatar"></el-avatar> <!-- 作者头像 -->
                            <span class="author-name">{{ author }}</span>
                            <span class="views">{{ views }} 次阅读</span> <!-- 阅读量展示 -->
                        </div>
                    </header>
                    <hr>
                    <!-- MdPreview 组件，用于预览文件内容 -->
                    <MdPreview :editorId="id" :modelValue="content"/>
                </el-main>
            </el-container>
        </div>
    </div>

</template>

<script setup>
import { MdCatalog, MdPreview } from 'md-editor-v3';
import 'md-editor-v3/lib/style.css';
import { ref } from 'vue';
import { useArticleStore } from "@/stores/article.js";
import {userInfoByIdService} from "@/api/user.js";
import {articleViewAddService, articleViewService} from "@/api/article.js";



const id = 'preview-only';
const scrollElement = document.documentElement;
const articleStore = useArticleStore();
let fileName = ref('');
const content = ref('');
const author = ref('未知用户'); // 添加作者信息

const authorAvatar = ref('@/assets/default.png'); // 作者头像链接
const views = ref(0); // 阅读量示例数据


//增加阅读量
const increaseViews = async () => {
    try {
        const response = await articleViewAddService(articleStore.article.id);
        console.log(response);
        if (response.code === 0) { // 根据code判断是否成功
            const data = response.data; // 直接提取data
            if (data) {
                views.value = data; // 更新阅读量
                console.log('阅读量更新成功');
            } else {
                console.error('未返回有效的阅读量数据:',data);
            }
        }
    }catch (error){
        console.error('增加阅读量时发生错误:', error);
    }
}
increaseViews();

//获取阅读量
const fetchViews = async () => {
    try {
        const response = await articleViewService(articleStore.article.id);
        console.log(response);

        if (response.code === 0) { // 根据code判断是否成功
            const data = response.data; // 直接提取data
            if (data) {
                views.value = data; // 更新阅读量
                console.log('阅读量更新成功');
            } else {
                console.error('未返回有效的阅读量数据:', data);
            }
        }
    }catch (error){
        console.error('获取阅读量时发生错误:', error);
    }
}
fetchViews();
//获取作者
const fetchAuthor = async () => {
    try {
        const response = await userInfoByIdService(articleStore.article.createUser);
        console.log(response);

        if (response.code === 0) { // 根据code判断是否成功
            const data = response.data; // 直接提取data

            if (data) {
                author.value = data.username || '未知用户';
                authorAvatar.value = data.userPic || '@/assets/default.png'; // 确保使用正确的头像属性
            } else {
                console.error('未返回有效的用户数据:', data);
            }
        } else {
            console.error('请求失败，错误信息:', response.message);
        }
    } catch (error) {
        console.error('获取作者信息时发生错误:', error);
    }
};


fetchAuthor();

const fetchFileContent = async () => {
    try {
        const parts = articleStore.article.content.split('/');
        fileName.value = parts[parts.length - 1];
        console.log(fileName.value);
        const response = await fetch('/file/' + fileName.value);
        if (response.ok) {
            content.value = await response.text();
        } else {
            console.error('Error fetching file:', response.status);
        }
    } catch (error) {
        console.error('Error fetching file:', error);
    }
};
fetchFileContent();

</script>

<style scoped>
.scrollbar-demo-item {
    display: flex;
    height: 100vh;
    border-radius: 4px;
}

.fixed-section {
    position: fixed;
    background-color: #f3f4f6;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.main-section {
    margin-left: 250px;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


/* 内容头部的样式 */
.content-header {
    display: flex; /* 使用弹性布局 */
    justify-content: space-between; /* 左右两侧对齐 */
    align-items: center; /* 垂直居中 */
}

/* 内容标题的样式 */
.content-title {
    font-size: 36px; /* 字体大小 */
    font-weight: bold; /* 字体加粗 */
    color: #333; /* 字体颜色 */
    margin-top: 0; /* 去掉顶部外边距 */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2); /* 字体阴影 */
}

/* 作者信息的样式 */
.author-info {
    display: flex; /* 使用弹性布局 */
    flex-direction: column; /* 纵向排列 */
    align-items: flex-end; /* 右对齐 */
    text-align: right; /* 文字右对齐 */
}

/* 作者头像样式 */
.author-avatar {
    width: 50px; /* 头像宽度 */
    height: 50px; /* 头像高度 */
    border-radius: 50%; /* 圆形头像 */
    margin-bottom: 5px; /* 头像与名字之间的间距 */
}

/* 作者名字样式 */
.author-name {
    font-size: 20px; /* 字体大小 */
    font-weight: bold; /* 字体加粗 */
    color: #333; /* 字体颜色 */
    margin-bottom: 2px; /* 名字与阅读量之间的间距 */
}

/* 阅读量样式 */
.views {
    font-size: 14px; /* 字体大小 */
    color: #666; /* 字体颜色 */
}
</style>
