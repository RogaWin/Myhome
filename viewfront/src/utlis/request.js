//定制请求的实例

//导入axios  npm install axios
import axios from 'axios';
import {ElMessage} from "element-plus";
//定义一个变量,记录公共的前缀  ,  baseURL
const baseURL = '/api';
const instance = axios.create({baseURL})
//添加请求拦截器
import {useTokenStore} from '@/stores/token.js'
instance.interceptors.request.use(
    (config)=>{
        //在请求头中添加token
        const tokenStore = useTokenStore();
        if(tokenStore.token){
            config.headers.Authorization = tokenStore.token;
        }
        return config;
    },
    (err)=>{
        return Promise.reject(err);
    }
)


// import {useRouter} from "vue-router";
// const router = useRouter();

import router from '@/router'
//添加响应拦截器
instance.interceptors.response.use(
    result=>{
        if(result.data.code===0){
            return result.data;
        }else if(result.data.code===2){
            return result.data;
        }
        else{
            //操作失败
            // alert(result.data.msg?result.data.msg:'服务异常');
            ElMessage.error(result.data.msg?result.data.msg:'服务异常');
            //异步操作的状态转换为失败
            return Promise.reject(result.data);
        }
    },
   err => {
    // 可以根据错误类型进行不同处理
        switch (err.response.status) {
            case 400:
                ElMessage.error('请求错误 (400)');
                break;
            case 401:
                ElMessage.error('未授权，请重新登录 (401)');
                router.push('/login');
                break;
            case 403:
                ElMessage.error('拒绝访问 (403)');
                break;
            case 404:
                ElMessage.error('请求出错 (404)');
                break;
            case 500:
                ElMessage.error('服务器错误 (500)');
                break;
            default:
                ElMessage.error(`连接出错 (${response.status})!`);
        }
    // 可以将错误日志记录到某个服务或者本地存储
    console.error('Error:', err);

    // 返回一个被拒绝的 promise，确保异步操作的失败状态
    return Promise.reject(err);
}
)

export default instance;