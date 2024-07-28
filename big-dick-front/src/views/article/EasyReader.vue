<template>
    <MdPreview :editorId="id" :modelValue="text" />
    <MdCatalog :editorId="id" :scrollElement="scrollElement" />
</template>

<script setup>
import { ref } from 'vue';
import { MdPreview, MdCatalog } from 'md-editor-v3';
// preview.css相比style.css少了编辑器那部分样式
import 'md-editor-v3/lib/preview.css';

const id = 'preview-only';
const text = ref('# Hello Editor' +
    'Hello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello EditorHello Editor');
const scrollElement = document.documentElement;
</script>