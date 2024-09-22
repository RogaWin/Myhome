import request from '@/utlis/request.js'

export const userRegisterService = (registerData)=>{
    //借助urlSearchParams完成
    const params = new URLSearchParams();
    for (let key in registerData){
        params.append(key,registerData[key]);
    }
    return request.post('/user/register',params);
}

export const userLoginService = (loginData)=>{
    const params = new URLSearchParams();
    for (let key in loginData){
        params.append(key,loginData[key]);
    }
    return request.post('/user/login',params);
}

export const UserInfoService = ()=>{
    return request.get('/user/userInfo');
}

export const UserInfoUpdateService =(userInfoData)=>{
    return request.put('/user/update',userInfoData);
}

export const userAvatarUpdateService = (avatarUrl)=>{
    const params = new URLSearchParams();
    params.append('avatarUrl',avatarUrl);
    return request.patch('/user/updateAvatar',params);
}

export const userPasswordUpdateService = (passwordData)=>{
    return request.patch('/user/updatePwd',passwordData);
}