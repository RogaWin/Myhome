//定义store
import {defineStore } from 'pinia'
import {ref} from 'vue'
import {useTokenStore} from "@/stores/token.js";
/**
 * 第一个参数名字
 * 第二个参数函数内部定义状态内容
 */
export const useArticleStore = defineStore(
    'article',
    ()=>{
        //响应式变量
        const article = ref({
            title: '',
            categoryId: '',
            coverImg: '',
            content:'',
            state:'',
            id:''
        })
        const setArticle = (newArticle)=>{
            article.value = newArticle //修改Article
        }
        const removeArticle = ()=>{
            article.value = ''
        }
        return {
            article,
            setArticle,
            removeArticle
        }
    }, {
        persist:true //持久化存储
    }
);