<template>
    <div id="home_page">
        <input
                type="text"
                v-model="keywords"
                @keydown.enter="search"
                @keyup="getSearchData"
                @blur="hideData"
        />
        <button @click="search">搜索</button>
        <div>搜索记录：</div>
        <span
                class="search-history"
                v-for="(item, index) in searchHistory"
                :key="index"
                @click="resetSearch(item)"
        >
      {{ item }} &nbsp;
    </span>
        <ul class="show_data" v-show="isShow">
            <li v-for="(item, index) in data" :key="index">{{ item }}</li>
        </ul>
        <ul>
            <li v-for="(item, index) in result" :key="index">{{ item }}</li>
        </ul>
    </div>
</template>

<script setup>
import {ref} from "vue";
const goodsList = ["html", "css", "javascript", "html5", "css3", "vue", "react", "node"];
const keywords = ref("");
const result = ref([]);
const data = ref([]);
const isShow = ref(false);
const searchHistory = ref([]);
const search = () => {
    result.value = goodsList.filter(item => item.includes(keywords.value));
    if (!searchHistory.value.includes(keywords.value)) {
        searchHistory.value.push(keywords.value);
    }
    isShow.value = false;
};
const getSearchData = (event) => {
    if (event.keyCode === 13) {
        isShow.value = false;
        return;
    }
    data.value = goodsList.filter(item => item.includes(keywords.value));
    isShow.value = true;
};

const hideData = () => {
    isShow.value = false;
};
const resetSearch = (kw) => {
    keywords.value = kw;
    search();
};
</script>

<style scoped>
#home_page {
    margin: 50px 0;
}
.show_data {
    border: 1px solid #999;
    list-style: none;
    padding: 0;
    margin: 0;
    width: 154px;
    padding: 10px 5px;
}
.search-history {
    color: #222;
    cursor: pointer;
}
.search-history:hover {
    color: red;
}
</style>
