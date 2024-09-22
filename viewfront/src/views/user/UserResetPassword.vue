<script setup>
import {Lock} from '@element-plus/icons-vue'
//控制注册与登录表单的显示， 默认显示注册
//注册表单数据
import {ref} from 'vue'


const newPwdData = ref({
    oldPassword: '',
    password: '',
    repeatPassword: ''
})  // 定义一个对象，用于存储注册表单的数据

const checkRePassword = (rule, value, callback) => {
    if (value === '') {
        callback(new Error('请再次输入密码'))  // 如果重复密码为空，返回错误信息
    } else if (value !== newPwdData.value.password) {
        callback(new Error('两次输入密码不一致'))  // 如果重复密码与密码不一致，返回错误信息
    } else {
        callback()  // 否则，验证通过
    }
}

const rules = {
    oldPassword: [
        {required: true, message: '请输入密码', trigger: 'blur'},
        {min: 5, max: 16, message: '长度为5到16位非空字符', trigger: 'blur'}
    ],
    password: [
        {required: true, message: '请输入密码', trigger: 'blur'},
        {min: 5, max: 16, message: '长度为5到16位非空字符', trigger: 'blur'}
    ],
    repeatPassword: [
        {validator: checkRePassword, trigger: 'blur'}
    ]
}

import {userLoginService, userPasswordUpdateService} from '@/api/user.js'
import {ElMessage} from "element-plus";
import useUserInfoStore from "@/stores/userinfo.js";
const userInfoStore = useUserInfoStore();
const updatePassword = async () => {
    //调用函数
    let loginData = {
        username: userInfoStore.info.username,
        password: newPwdData.value.oldPassword
    }
    let result = await userLoginService(loginData);
    if(result.code===0){
        let data = {
            old_pwd: newPwdData.value.oldPassword,
            new_pwd: newPwdData.value.password,
            re_pwd: newPwdData.value.repeatPassword
        }
        //调用函数
        await userPasswordUpdateService(data);
        ElMessage.success('修改成功');
    }else{
        ElMessage.error('老密码错误');
    }

}
</script>
<template>
    <el-card class="page-container">
        <template #header>
            <div class="header">
                <span>修改密码</span>
            </div>
        </template>
        <el-row>
            <el-col :span="12">
                <el-form ref="form" size="large" autocomplete="on" :rules="rules" :model="newPwdData"
                         label-width="100px">
                    <el-form-item prop="oldPassword" label="旧密码">
                        <el-input :prefix-icon="Lock" type="password" placeholder="请输入密码"
                                  v-model="newPwdData.oldPassword"></el-input>
                    </el-form-item>
                    <el-form-item prop="password" label="新密码">
                        <el-input :prefix-icon="Lock" type="password" placeholder="请输入密码"
                                  v-model="newPwdData.password"></el-input>
                    </el-form-item>
                    <el-form-item prop="repeatPassword" label="确认新密码">
                        <el-input :prefix-icon="Lock" type="password" placeholder="请输入再次密码"
                                  v-model="newPwdData.repeatPassword"></el-input>
                    </el-form-item>
                    <!-- 注册按钮 -->
                    <el-form-item>
                        <el-button class="button" type="primary" auto-insert-space @click="updatePassword()">
                            确定修改
                        </el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </el-card>
</template>