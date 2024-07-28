<template>
    <div class="editor-container">
        <el-header class="header">
            <el-button type="" @click="importFile">导入文件</el-button>
            <el-button type="" @click="exportFile">导出文件</el-button>
        </el-header>
        <splitpanes class="default-theme" horizontal>
            <pane min-size="30">
                <md-editor
                    v-model="content"
                    theme="dark"
                    :toolbars="toolbars"
                    @onSave="saveContent"
                    @onLoad="setToolbarShortcuts"
                />
            </pane>

        </splitpanes>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import {MdEditor} from 'md-editor-v3';
import { Splitpanes, Pane } from 'splitpanes';
import 'splitpanes/dist/splitpanes.css';
import 'md-editor-v3/lib/style.css';
import 'element-plus/dist/index.css';

const content = ref('');
import { config } from 'md-editor-v3';




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

const setToolbarShortcuts = () => {
    const toolbarButtons = document.querySelectorAll('.md-editor-v3-toolbar button');
    toolbarButtons.forEach((button) => {
        const action = button.getAttribute('data-action');
        if (shortcuts[action]) {
            button.setAttribute('title', `${button.getAttribute('title')} (${shortcuts[action]})`);
        }
    });
};
</script>

<style scoped>
.editor-container {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.header {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
    background-color: #333;
    color: white;
}

.default-theme {
    height: calc(100% - 50px); /* Adjust for the header height */
}

.preview {
    padding: 20px;
    background-color: #fff;
    overflow: auto;
}
</style>
