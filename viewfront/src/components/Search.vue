<template>
    <el-autocomplete
        v-model="customSearchQuery"
        :fetch-suggestions="querySearchAsync"
        placeholder="Type to search..."
        @select="handleSelect"
        @keyup.enter="performCustomSearch"
    />
</template>

<script lang="ts" setup>
import { onMounted, ref, defineProps, defineEmits } from 'vue'

interface LinkItem {
    value: string
    link: string
}

const props = defineProps<{
    placeholder?: string
}>()

const emit = defineEmits<{
    (event: 'select', item: LinkItem): void
}>()

const links = ref<LinkItem[]>([])
const customSearchQuery = ref('')

const loadAll = () => {
    return [
        { value: 'vue', link: 'https://github.com/vuejs/vue' },
        { value: 'element', link: 'https://github.com/ElemeFE/element' },
        { value: 'cooking', link: 'https://github.com/ElemeFE/cooking' },
        { value: 'mint-ui', link: 'https://github.com/ElemeFE/mint-ui' },
        { value: 'vuex', link: 'https://github.com/vuejs/vuex' },
        { value: 'vue-router', link: 'https://github.com/vuejs/vue-router' },
        { value: 'babel', link: 'https://github.com/babel/babel' },
    ]
}

let timeout: ReturnType<typeof setTimeout>
const querySearchAsync = (queryString: string, cb: (arg: LinkItem[]) => void) => {
    const results = queryString
        ? links.value.filter(createFilter(queryString))
        : links.value

    clearTimeout(timeout)
    timeout = setTimeout(() => {
        cb(results)
    }, 300 * Math.random())
}

const createFilter = (queryString: string) => {
    return (linkItem: LinkItem) => {
        return (
            linkItem.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0
        )
    }
}

const handleSelect = (item: LinkItem) => {
    emit('select', item)
    const searchQuery = encodeURIComponent(item.value);
    window.open(`https://www.google.com/search?q=${searchQuery}`, '_blank');
}

const performCustomSearch = () => {
    if (customSearchQuery.value) {
        const searchQuery = encodeURIComponent(customSearchQuery.value);
        window.open(`https://www.google.com/search?q=${searchQuery}`, '_blank');
        customSearchQuery.value = ''; // 清空输入框
    }
}

onMounted(() => {
    links.value = loadAll()
})
</script>
