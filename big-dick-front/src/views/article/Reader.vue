<template>
    <div>
        <div class="common-layout">
            <!-- 使用 Element Plus 的 Container 组件来布局 -->
            <el-container>
                <!-- 固定的侧边栏，宽度为250px -->
                <el-aside width="250px" class="fixed-section">
                    <el-scrollbar class="scrollbar-demo-item">
                        <!-- 文件上传输入框，调用 handleFileUpload 方法处理文件上传 -->
                        <input type="file" @change="handleFileUpload"/>
                        <!-- 目录标题 -->
                        <span class="section-font">目录</span>
                        <!-- MdCatalog 组件，用于显示目录，绑定事件和参数 -->
                        <MdCatalog :editorId="id" :scrollElement="scrollElement" @clickTitle="handleClickTitle"/>
                    </el-scrollbar>
                </el-aside>
                <!-- 主内容区域 -->
                <el-main class="main-section">
                    <!-- MdPreview 组件，用于预览文件内容 -->
                    <span class="section-font">内容</span>
                    <MdPreview :editorId="id" :modelValue="text"/>
                </el-main>
            </el-container>
        </div>
    </div>
</template>

<script setup>
import {MdCatalog, MdPreview} from 'md-editor-v3'; // 导入 md-editor-v3 组件
import 'md-editor-v3/lib/style.css'; // 导入 md-editor-v3 的样式
import {ref, reactive} from 'vue'; // 导入 Vue 的 ref 和 reactive 函数

const text = ref(''); // 定义一个响应式变量 text，用于存储文件内容
const id = 'preview-only'; // 定义 editorId
const scrollElement = document.documentElement; // 定义 scrollElement，指向 document 的根元素


// 处理文件上传的函数
const handleFileUpload = (event) => {
    // 获取用户上传的第一个文件
    const file = event.target.files[0];
    if (file) {
        // 创建一个 FileReader 对象
        const reader = new FileReader();
        // 以文本形式读取文件内容
        reader.readAsText(file);
        // 定义文件读取完成后的回调函数
        reader.onload = (e) => {
            // 将读取的文件内容赋值给 text
            text.value = e.target.result;
        };
    }
};

// 定义一个响应式对象 state
const state = reactive({
    text: '', // 用于存储文本内容
    catalogList: [] // 用于存储目录列表
});
</script>

<style scoped>
/* 滚动条示例项的样式 */
.scrollbar-demo-item {
    display: flex; /* 设置为弹性布局 */
    height: 100vh; /* 高度占满整个视口 */
    border-radius: 4px; /* 设置圆角 */
}

/* 固定侧边栏的样式 */
.fixed-section {
    position: fixed; /* 固定位置 */
}

/* 主内容区域的样式 */
.main-section {
    margin-left: 250px; /* 确保内容不被固定侧边栏遮挡 */
}

/* 目录标题的样式 */
.section-font {
    font-size: 30px; /* 字体大小 */
    font-weight: bold; /* 字体加粗 */
    margin-bottom: 10px; /* 下外边距 */
}
</style>
