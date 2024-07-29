import {defineStore} from 'pinia'
import {ref} from 'vue'
const useUserInfoStore = defineStore('userinfo',()=>{
    //定义状态内容
    const info = ref({});
    const setInfo =(newInfo)=>{
        info.value=newInfo;
    }
    const removeInfo=()=>{
        info.value={};
    }
    return{
        info,
        setInfo,
        removeInfo
    }
},
    {
        LocalStorage:true
    }
)

export default useUserInfoStore