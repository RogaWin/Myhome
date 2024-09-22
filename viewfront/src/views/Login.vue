<script setup>
import { User, Lock } from '@element-plus/icons-vue'
import { ref } from 'vue'
import { ElMessage } from 'element-plus'
//控制注册与登录表单的显示， 默认显示注册
//注册表单数据
const isRegister = ref(false), registerData = ref({
    username: '',
    password: '',
    repeatPassword: ''
}),
    checkRePassword = (rule, value, callback) => {
    if (value === '') {
        callback(new Error('请再次输入密码'))
    } else if (value !== registerData.value.password) {
        callback(new Error('两次输入密码不一致'))
    } else {
        callback()
    }
},
    rules = {
    username: [
        {required: true, message: '请输入用户名', trigger: 'blur'},
        {min: 5, max: 16, message: '长度为5到16位非空字符', trigger: 'blur'}
    ],
    password: [
        {required: true, message: '请输入密码', trigger: 'blur'},
        {min: 5, max: 16, message: '长度为5到16位非空字符', trigger: 'blur'}
    ],
    repeatPassword: [
        {
            validator: checkRePassword,
            trigger: 'blur'
        }
    ]
};

//调用后台接口,完成注册
import {userRegisterService, userLoginService, UserInfoService} from '@/api/user.js'
const register =async () => {
    //registerData是想响应式对象
    // let result = await userRegisterService(registerData.value);
    // if(result.code === 0){
    //     alert(result.msg?result.msg:'注册成功');
    // }else{
    //     alert("注册失败")
    // }
    let result = await userRegisterService(registerData.value);
    ElMessage.success(result.msg?result.msg:'注册成功');
}

//登录函数
import {useTokenStore} from '@/stores/token.js'
import {useRouter} from 'vue-router'
import useUserInfoStore from "@/stores/userinfo.js";

const userInfoStore=useUserInfoStore();
const router = useRouter();
const tokenStore = useTokenStore();
const getUserInfo = async () => {
    let result = await UserInfoService();
    // 数据存储到 Pinia 中
    userInfoStore.setInfo(result.data);
};

const login = async() => {
    //调用接口完成登入
    // userLoginService(registerData.value).then(result=>{
    //     if(result.code === 0){
    //         alert(result.msg?result.msg:'登录成功');
    //     }else{
    //         alert("登录失败")
    //     }
    // })
    let result = await userLoginService(registerData.value);
    ElMessage.success(result.msg?result.msg:'登录成功');
    tokenStore.setToken(result.data);
    await getUserInfo();
    await router.push('/home');
}
//定义函数用于清空数据模型数据
const clearRegisterData = () => {
    registerData.value.username = '';
    registerData.value.password = '';
    registerData.value.repeatPassword = '';
}
</script>

<template>
    <el-row class="login-page">
        <el-col :span="12" class="bg"></el-col>
        <el-col :span="6" :offset="3" class="form">
            <!-- 注册表单 -->
            <el-form ref="form" size="large" autocomplete="off" v-if="isRegister" :rules="rules" :model="registerData">
                <el-form-item>
                    <h1>注册</h1>
                </el-form-item>
                <el-form-item prop="username">
                    <el-input :prefix-icon="User" placeholder="请输入用户名" v-model="registerData.username"></el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input :prefix-icon="Lock" type="password" placeholder="请输入密码" v-model="registerData.password"></el-input>
                </el-form-item>
                <el-form-item prop="repeatPassword">
                    <el-input :prefix-icon="Lock" type="password" placeholder="请输入再次密码" v-model="registerData.repeatPassword"></el-input>
                </el-form-item>
                <!-- 注册按钮 -->
                <el-form-item>
                    <el-button class="button" type="primary" auto-insert-space @click="register()">
                        注册
                    </el-button>
                </el-form-item>
                <el-form-item class="flex">
                    <el-link type="info" :underline="false" @click="isRegister = false;clearRegisterData()">
                        ← 返回
                    </el-link>
                </el-form-item>
            </el-form>
            <!-- 登录表单 -->
            <el-form ref="form" size="large" autocomplete="off" v-else :model="registerData" :rules="rules">
                <el-form-item>
                    <h1>登录</h1>
                </el-form-item>
                <el-form-item prop="username">
                    <el-input :prefix-icon="User" placeholder="请输入用户名" v-model="registerData.username"></el-input>
                </el-form-item>
                <el-form-item prop="password">
                    <el-input name="password" :prefix-icon="Lock" type="password" placeholder="请输入密码" v-model="registerData.password"></el-input>
                </el-form-item>
                <el-form-item class="flex">
                    <div class="flex">
                        <el-checkbox>记住我</el-checkbox>
                        <el-link type="primary" :underline="false">忘记密码？</el-link>
                    </div>
                </el-form-item>
                <!-- 登录按钮 -->
                <el-form-item>
                    <el-button class="button" type="primary" auto-insert-space @click="login()">登录</el-button>
                </el-form-item>
                <el-form-item class="flex">
                    <div class="flex">
                        <el-link type="info" :underline="false" @click="isRegister = true;clearRegisterData()">
                            注册 →
                        </el-link>
                        <el-link type="info" :underline="false" @click="isRegister = true;clearRegisterData()" >
                          跳过只看文章
                        </el-link>
                    </div>

                </el-form-item>

            </el-form>
        </el-col>
    </el-row>
</template>

<style lang="scss" scoped>
/* 样式 */
.login-page {
    height: 100vh;
    background-color: #fff;

    .bg {
        background: url('@/assets/login_bg.jpg') no-repeat 60% center / 240px auto,
        url('@/assets/login_bg.jpg') no-repeat center / cover;
        border-radius: 0 20px 20px 0;
    }

    .form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        user-select: none;

        .title {
            margin: 0 auto;
        }

        .button {
            width: 100%;
        }

        .flex {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
    }
}
</style>