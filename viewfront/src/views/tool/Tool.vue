<template>
    <div class="common-layout">
        <el-container>
            <el-header class="header">
                <div class="title-container">
                    <span v-for="(letter, index) in title" :key="index" class="letter">{{ letter }}</span>
                </div>
                <div class="search-container">
                    <Search
                        class="search-input"
                        placeholder="请输入关键字"
                        @select="handleSelect"
                    />
                </div>
            </el-header>
            <el-main class="main">
                <div class="toolbox">
                    <el-row :gutter="20">
                        <el-col :span="8" v-for="(tool, index) in tools" :key="index">
                            <a :href="tool.path"  rel="noopener noreferrer">
                                <el-card shadow="always" class="tool-card">
                                    <div class="tool-card-content">
                                        <div class="icon">
                                            <div class="icon-bg">
                                                <el-icon class="icon-element" :style="{ fontSize: '50px' }">
                                                    <component :is="tool.icon" />
                                                </el-icon>
                                            </div>
                                        </div>
                                        <div class="tool-info">
                                            <h3>{{ tool.name }}</h3>
                                            <p>{{ tool.description }}</p>
                                        </div>
                                    </div>
                                </el-card>
                            </a>
                        </el-col>
                    </el-row>
                </div>
            </el-main>
        </el-container>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import {
    HomeFilled,
    UserFilled,
    Ticket,
    BellFilled,
    Document,
    InfoFilled
} from '@element-plus/icons-vue';
import Search from '@/components/Search.vue';
import router from "@/router/index.js";

const handleSelect = (item) => {
    console.log('Selected item:', item);
}

const tools = ref([
    { name: '首页', description: '回到首页', icon: HomeFilled, path: '/' },
    { name: '文章管理', description: '管理文章信息', icon: UserFilled, path: '/article/manage' },
    { name: '小游戏', description: '小游戏', icon: Ticket, path: '/game' },
    { name: '留言', description: '查看留言消息', icon: BellFilled, path: '/message' },
    { name: 'PDF工具', description: 'pdf工具', icon: Document, path: 'https://tools.pdf24.org/zh/all-tools' },
    { name: '关于我们', description: '了解更多信息', icon: InfoFilled, path: '/about' },
]);

const title = ref('welcome to CSRoGa !!!'.split(''));
</script>

<style scoped>
.common-layout {
    min-height: 100vh;
    background: radial-gradient(circle at center, #0f0c29, #302b63, #24243e);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.header {
    display: flex;
    flex-direction: column; /* 让标题和搜索框垂直排列 */
    align-items: center; /* 中心对齐 */
    margin-bottom: 20px; /* 增加下边距，避免重叠 */
}

.title-container {
    margin-bottom: 10px; /* 标题和搜索框之间的间距 */
}

.toolbox {
    width: 80%;
    padding: 10px;
    margin-left: 10%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.tool-card {
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
    border-radius: 15px;
    border: 1px solid rgba(0, 245, 255, 0.5);
    box-shadow: 0px 0px 15px rgba(0, 245, 255, 0.2);
    background-color: rgba(0, 0, 0, 0.8);
}

.tool-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 245, 255, 0.8), 0 0 30px rgba(0, 245, 255, 0.5);
}

.tool-card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.icon {
    margin-bottom: 15px;
    position: relative;
}

.icon-bg {
    background: linear-gradient(135deg, #00f5ff, #7f00ff);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 5px 20px rgba(0, 245, 255, 0.7);
    z-index: 1;
}

.icon-element {
    color: #fff;
    z-index: 2;
}

.tool-info {
    text-align: center;
}

h3 {
    margin: 0;
    font-size: 20px;
    color: #fff;
    font-weight: bold;
    text-shadow: 0px 0px 5px rgba(0, 245, 255, 0.8);
}

p {
    color: #b0bec5;
    font-size: 14px;
}

a {
    text-decoration: none;
}

.router-link-exact-active .tool-card {
    border-color: #7f00ff;
}

@keyframes fadeIn {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.letter {
    font-size: 50px;
    font-weight: bold;
    color: #00f5ff;
    text-shadow: 0px 0px 10px #00f5ff, 0px 0px 20px #00f5ff;
    opacity: 0;
    transform: translateY(-50px);
    animation: fadeIn 0.5s forwards;
}

.search-input {
    width: calc(100% - 40px); /* 根据需要调整宽度 */
    max-width: 200px; /* 设置最大宽度以防过长 */
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 50px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: border-color 0.3s, box-shadow 0.3s;
    padding: 10px 15px;
}

.search-input::placeholder {
    color: red;
    font-style: italic;
}

/*设置边框变色*/
.search-input:focus {
    border: 5px solid #00f5ff;
    box-shadow: 0 0 10px rgba(0, 245, 255, 0.5);
    outline: none;
}

/*长度为一半父组件*/
.search-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 75%;
}

.letter:nth-child(1) { animation-delay: 0.1s; }
.letter:nth-child(2) { animation-delay: 0.3s; }
.letter:nth-child(3) { animation-delay: 0.5s; }
.letter:nth-child(4) { animation-delay: 0.7s; }
.letter:nth-child(5) { animation-delay: 0.9s; }
.letter:nth-child(6) { animation-delay: 1.1s; }
.letter:nth-child(7) { animation-delay: 1.3s; }
.letter:nth-child(8) { animation-delay: 1.5s; }
.letter:nth-child(9) { animation-delay: 0.1s; }
.letter:nth-child(10) { animation-delay: 0.3s; }
.letter:nth-child(11) { animation-delay: 0.5s; }
.letter:nth-child(12) { animation-delay: 0.1s; }
.letter:nth-child(13) { animation-delay: 0.3s; }
.letter:nth-child(14) { animation-delay: 0.5s; }
.letter:nth-child(15) { animation-delay: 0.7s; }
.letter:nth-child(16) { animation-delay: 0.9s; }
.letter:nth-child(17) { animation-delay: 1.1s; }
.letter:nth-child(18) { animation-delay: 1.9s; }
.letter:nth-child(19) { animation-delay: 2.0s; }
.letter:nth-child(20) { animation-delay: 2.1s; }
.letter:nth-child(21) { animation-delay: 2.2s; }
</style>
