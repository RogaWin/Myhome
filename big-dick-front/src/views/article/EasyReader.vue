<template>
    <MdPreview :editorId="id" :modelValue="content" />
</template>

<script setup>
import { MdPreview, MdCatalog } from 'md-editor-v3';
// preview.css相比style.css少了编辑器那部分样式
import 'md-editor-v3/lib/preview.css';
const props = defineProps({
    content: {
    type: String,
    default: '# Hello Editor ',
    required: true
  }
});

const id = 'preview-only';
</script>