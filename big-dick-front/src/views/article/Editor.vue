<template>
    <div>

        //老版本上传文件
        <!--        <input type="file" @change="handleFileUpload" />-->
        <input type="file" @change="handleFileUpload"/>
        <MdEditor v-model="text" />
    </div>
</template>

<script setup>
import { defineComponent, ref } from 'vue';
import { MdEditor } from 'md-editor-v3';
import 'md-editor-v3/lib/style.css';


const text = ref('');


//测试
import {useRouter} from "vue-router";
const router = useRouter();
const handleFileUpload = (event) => {
    // 获取用户上传的第一个文件
    const file = event.target.files[0];
    if (file) {
        // 创建一个 FileReader 对象
        const reader = new FileReader();
        // 定义文件读取完成后的回调函数
        reader.onload = (e) => {
            // 将读取的文件内容赋值给 text
            text.value = e.target.result;
            router.push({
                path: '/article/add',
                query: {
                    content: text
                }
            })
        };
        // 以文本形式读取文件内容
        reader.readAsText(file);
    }
};


</script>

<style scoped>
/* Add any scoped styles if necessary */
</style>
