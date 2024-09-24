<script setup>
import {onMounted, ref, watch} from 'vue';
import { MdEditor } from 'md-editor-v3';
import { Pane, Splitpanes } from 'splitpanes';
import 'splitpanes/dist/splitpanes.css';
import 'md-editor-v3/lib/style.css';
import 'element-plus/dist/index.css';
import useUserInfoStore from "@/stores/userinfo.js";
import { CaretBottom, Crop, EditPen, SwitchButton, User, Plus } from '@element-plus/icons-vue';
import { useRouter } from "vue-router";
import { useTokenStore } from "@/stores/token.js";
import Reader from "@/views/article/EasyReader.vue";
import {articleAddService, articleCategoryListService, articleUpdateService} from "@/api/article.js";
import  avatar from '@/assets/avatar.jpg';




const userInfoStore = useUserInfoStore();

let inputTitle = ref('');
const content = ref('');
import {ElLoading, ElMessage, ElMessageBox} from "element-plus";



import {useArticleStore} from "@/stores/article.js";
const articleStore = useArticleStore();
//发布文章还是修改文章
let title = ref('');


let fileName=ref('');
const fetchFileContent = async () => {
    try {
        title="添加文章";
        const parts = articleStore.article.content.split('/');
        fileName =parts[parts.length-1];
        console.log(fileName)
        const response = await fetch('/file/'+fileName) // 通过代理获取新的外部文件内容
        if (response.ok) {
            inputTitle.value = articleStore.article.title;
            title="编辑文章";
            content.value = await response.text()
        } else {
            console.error('Error fetching file:', error)
        }
    } catch (error) {
        console.error('Error fetching file:', error)
    }
}
fetchFileContent()


// Watch content changes and save to localStorage
watch(content, (newContent) => {
    localStorage.setItem('editorContent', newContent);
});

// 导入功能
const importFile = () => {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.md';
    input.onchange = async (event) => {
        const file = event.target.files[0];
        content.value = await file.text();
    };
    input.click();
};

// 导出功能
const exportFile = () => {
    const blob = new Blob([content.value], { type: 'text/markdown' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = inputTitle.value + '.md';
    link.click();
};

// 保存功能
const saveContent = () => {
    console.log('Content saved:', articleStore.article.content);
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
    }
    else if(command === 'manage'){
        router.push('/article/manage');
    }
    else {
        router.push('/user/' + command);
    }
};

// 返回文章管理界面
const router = useRouter();
import {uploadFileService,deleteFileService} from "@/api/file.js";

const reBack = () => {
    router.push('/article/manage');
};

// 添加表单数据模型
const articleModel = ref({
    title: '',
    categoryId: '',
    coverImg: '',
    content: '',
    state: '',
    introduction: ''
});

const tokenStore = useTokenStore();
// 发布文章弹出抽屉
const visibleDrawer = ref(false);




const publishArticle = () => {
    articleModel.value.title = inputTitle.value;
    articleModel.value.content = articleStore.article.content;
    articleModel.value.coverImg = articleStore.article.coverImg;
    articleModel.value.state=articleStore.article.state;
    articleModel.value.categoryId=articleStore.article.categoryId;
    articleModel.value.id=articleStore.article.id;
    visibleDrawer.value = true;
};

// const addArticle = async (clickState) => {
//
//
//
//     articleModel.value.title = inputTitle;
//     articleModel.value.state = clickState;
//     console.log(articleModel.value)
//     await articleAddService(articleModel.value);
//     ElMessage.success('添加成功');
//     visibleDrawer.value = false;
//     await articleList();
// };



const addArticle = async (clickState) => {
    try {
        const loadingInstance = ElLoading.service({ fullscreen: true });
        // 将文章内容打包为 Markdown 文件
        const markdownContent = `# ${inputTitle.value}\n\n${content.value}`;
        const blob = new Blob([markdownContent], { type: 'text/markdown' });
        const file = new File([blob], `${inputTitle.value}.md`, { type: 'text/markdown' });

        // 上传文件并获取 URL
        const formData = new FormData();
        formData.append('file', file);
        const uploadResponse = await uploadFileService(formData); // 这里假设 `uploadFileService` 是处理文件上传的服务
        const fileUrl = uploadResponse.data; // 根据实际的响应结构调整

        // 设置文章模型
        articleModel.value.title = inputTitle.value;
        articleModel.value.content = fileUrl; // 将文件 URL 存储在内容字段
        articleModel.value.state = clickState;
        // 将文章模型发送到后端服务
        console.log(articleModel.value);
        await articleAddService(articleModel.value);
        ElMessage.success('添加成功');
        visibleDrawer.value = false;
    } catch (error) {
        ElMessage.error('添加失败，请重试');
        console.error(error);
    } finally {
        ElLoading.service().close();
        await router.push('/article/manage')
    }
};

const updateArticle = async (clickState) => {
    try {
        await deleteFileService(fileName.value);
        const loadingInstance = ElLoading.service({fullscreen: true});
        // 将文章内容打包为 Markdown 文件
        const markdownContent = `# ${content.value}`;
        console.log(content.value)
        const blob = new Blob([markdownContent], {type: 'text/markdown'});
        const file = new File([blob], `${inputTitle.value}.md`, {type: 'text/markdown'});

        // 上传文件并获取 URL
        const formData = new FormData();
        formData.append('file', file);
        const uploadResponse = await uploadFileService(formData); // 这里假设 `uploadFileService` 是处理文件上传的服务
        const fileUrl = uploadResponse.data; // 根据实际的响应结构调整

        // 设置文章模型
        articleModel.value.title = inputTitle.value;
        articleModel.value.content = fileUrl; // 将文件 URL 存储在内容字段
        articleModel.value.state = clickState;
        // 将文章模型发送到后端服务
        console.log(articleModel.value);
        await articleUpdateService(articleModel.value);
        ElMessage.success('修改成功');
        await articleStore.setArticle(articleModel.value);
        visibleDrawer.value = false;
    }
    catch (error) {
        ElMessage.error('添加失败，请重试');
        console.error(error);
    } finally {
        ElLoading.service().close();
    }
}



const uploadSuccess = (result) => {
    articleModel.value.coverImg = result.data;
    console.log(result.data);
};

const categorys = ref([
])

//获取所有的分类
const articleCategoryList = async () => {
    const result = await articleCategoryListService();
    categorys.value = result.data
}
//获取所有文章
articleCategoryList();





</script>

<template>
    <div class="editor-container">
        <el-header class="header">
            <div class="el-menu-container">
                <el-link class="menu-left" :underline="false" @click="reBack">
                    ←文章管理
                </el-link>
                <div class="menu-center">
                    <el-input
                        v-model="inputTitle"
                        class="title-input"
                        maxlength="100"
                        placeholder="请输入标题"
                        show-word-limit
                        type="text"
                    />
                    <el-button type="primary" @click="importFile">导入文件</el-button>
                    <el-button type="primary" @click="exportFile">导出文件</el-button>
                    <el-button type="primary" @click="publishArticle">发布文章</el-button>
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
        <!-- Editor所在位置 -->
        <splitpanes class="default-theme" horizontal>
            <pane min-size="30">
                <md-editor
                    v-model="content"
                    theme="dark"
                    @onSave="saveContent"
                    class="md-editor"
                />
            </pane>
        </splitpanes>
        <!-- 抽屉 -->
        <el-drawer v-model="visibleDrawer" :title=title direction="rtl" size="50%">
            <!-- 添加文章表单 -->
            <el-form :model="articleModel" label-width="100px">
                <el-form-item label="文章标题">
                    <el-input v-model="inputTitle" placeholder="请输入标题"></el-input>
                </el-form-item>
                <el-form-item label="文章分类">
                    <el-select placeholder="请选择" v-model="articleModel.categoryId">
                        <el-option v-for="c in categorys" :key="c.id" :label="c.categoryName" :value="c.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="文章封面">
                    <el-row>
                        <el-col >
                            <el-upload
                                class="avatar-uploader"
                                :auto-upload="true"
                                :show-file-list="false"
                                action="/api/upload"
                                name="file"
                                :headers="{'Authorization': tokenStore.token}"
                                :on-success="uploadSuccess"
                            >
                                <img v-if="articleModel.coverImg" :src="articleModel.coverImg" class="avatar" alt="上传的图片"/>
                                <el-icon v-else class="avatar-uploader-icon">
                                    <Plus />
                                </el-icon>
                            </el-upload>
                        </el-col>
                        <el-col label="文章简介">
                            <el-input  v-model="articleModel.introduction" type="textarea" placeholder="请输入简介"  style="width: 100%; min-width: 400px;" />
                        </el-col>
                    </el-row>
                </el-form-item>
                <el-form-item label="文章内容" >
                    <!-- TODO 嵌入Editor -->
                    <div class="editor" style="width: 100%;" >
                        <el-scrollbar max-height="260px" >
                            <Reader :content="content"/>
                        </el-scrollbar>
                    </div>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="title==='添加文章'?addArticle('已发布'):updateArticle('已发布')">发布</el-button>
                    <el-button type="info" @click="title==='添加文章'?addArticle('草稿'):updateArticle('草稿')">草稿</el-button>
                </el-form-item>
            </el-form>
        </el-drawer>

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
    height: 99%;
    width: 100%;
}

.avatar-uploader {
    display: inline-block;
    width: 178px;
    height: 178px;
    border: 1px dashed var(--el-border-color);
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: var(--el-transition-duration-fast);
}

.avatar-uploader img {
    width: 100%;
    height: 100%;
    display: block;
}

.avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 178px;
    height: 178px;
    text-align: center;
}

.avatar-uploader:hover {
    border-color: var(--el-color-primary);
}
</style>
