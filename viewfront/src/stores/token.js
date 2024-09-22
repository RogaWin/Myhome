//定义store
import {defineStore } from 'pinia'
import {ref} from 'vue'
/**
 * 第一个参数名字
 * 第二个参数函数内部定义状态内容
 */
export const useTokenStore = defineStore(
    'token',
    ()=>{
        //响应式变量
        const token = ref('')
        const setToken = (newToken)=>{
            token.value = newToken //修改token
        }
        const removeToken = ()=>{
            token.value = ''
        }
        return {
            token,
            setToken,
            removeToken
        }
    }, {
        persist:true //持久化存储
    }
);