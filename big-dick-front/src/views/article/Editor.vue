

<script setup>
import { ref, watch } from 'vue';
import { MdEditor } from 'md-editor-v3';
import { Splitpanes, Pane } from 'splitpanes';
import 'splitpanes/dist/splitpanes.css';
import 'md-editor-v3/lib/style.css';
import 'element-plus/dist/index.css';
import useUserInfoStore from "@/stores/userinfo.js";
import { CaretBottom, User, Crop, EditPen, SwitchButton } from '@element-plus/icons-vue';
import {useRouter} from "vue-router";

const userInfoStore = useUserInfoStore();
const avatar = 'path/to/default-avatar.png'; // Default avatar path
const title = ref('');
const content = ref(localStorage.getItem('editorContent') || '');

// Watch content changes and save to localStorage
watch(content, (newContent) => {
    localStorage.setItem('editorContent', newContent);
});

const importFile = () => {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.md';
    input.onchange = async (event) => {
        const file = event.target.files[0];
        const text = await file.text();
        content.value = text;
    };
    input.click();
};

const exportFile = () => {
    const blob = new Blob([content.value], { type: 'text/markdown' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'document.md';
    link.click();
};

const saveContent = () => {
    console.log('Content saved:', content.value);
};

const handleCommand = (command) => {
    console.log('Command:', command);
    // Handle commands here
};


//返回文章管理界面
const router = useRouter();
const reback = ()=>{
    router.push('/article/manage');
}
</script>
<template>
    <div class="editor-container">
        <el-header class="header">
            <div class="el-menu-container">
                <el-link class="menu-left" :underline="false" @click="reback">
                   ←文章管理
                </el-link>
                <div class="menu-center">
                    <el-input
                        v-model="title"
                        class="title-input"
                        maxlength="100"
                        placeholder="请输入标题"
                        show-word-limit
                        type="text"
                    />
                    <el-button type="primary" @click="importFile">导入文件</el-button>
                    <el-button type="primary" @click="exportFile">导出文件</el-button>
                    <el-button type="primary" @click="exportFile">发布文章</el-button>
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
                            <el-dropdown-menu>
                                <el-dropdown-item command="info" :icon="User">基本资料</el-dropdown-item>
                                <el-dropdown-item command="avatar" :icon="Crop">更换头像</el-dropdown-item>
                                <el-dropdown-item command="manage" :icon="EditPen">内容管理</el-dropdown-item>
                                <el-dropdown-item command="logout" :icon="SwitchButton">退出登录</el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </div>
            </div>
        </el-header>
        <splitpanes class="default-theme" horizontal>
            <pane min-size="30">
                <md-editor
                    v-model="content"
                    theme="dark"
                    :toolbars="toolbars"
                    @onSave="saveContent"
                    @onLoad="setToolbarShortcuts"
                    class="md-editor"
                />
            </pane>
        </splitpanes>
    </div>
</template>


<style scoped>
.editor-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.header {
    display: flex;
    align-items: center;
    padding: 10px;
    background-color: #333;
    color: white;
}

.el-menu-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.menu-left {
    flex: 1;
    font-size: 20px;
    font-weight: bold;
}

.menu-center {
    flex: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px; /* Add space between input and buttons */
}

.menu-right {
    flex: 1;
    display: flex;
    justify-content: flex-end;
}

.title-input {
    width: 700px;
    max-width: 800px; /* Adjust the max-width here */

}

.el-dropdown__box {
    display: flex;
    align-items: center;
    cursor: pointer;
}

.default-theme {
    height: calc(100% - 50px); /* Adjust for the header height */
}

.md-editor {
    height: 100%;
    width: 100%;
}

.preview {
    padding: 20px;
    background-color: #fff;
    overflow: auto;
}
</style>
