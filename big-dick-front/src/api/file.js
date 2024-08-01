
import request from "@/utlis/request.js";


//上传文件
export const uploadFileService = (file) => {
    return request({
        url: '/upload',
        method: 'post',
        data: file
    })
}

//删除文件
export const deleteFileService = (fileName) => {
    const params = new URLSearchParams();
    params.append('url',fileName);
    return request({
        url: '/deleteFile',
        method: 'post',
        data: params
    })
}