import request from '@/utlis/request.js'


//获取所有留言
export const messageListService = () => {
    return request.get('/message/list');
}

//删除留言
export const messageDeleteService = (messageId) => {
    return request.delete('/message/delete/', {params:{id:messageId}});
}

//查看详细
export const messageViewService = (messageId) => {
    return request.get('/message/view/', {params:{id:messageId}});
}

//添加留言
export const messageAddService = (messageData) => {
    return request.post('/message/add', messageData);
};

//修改留言
export const messageUpdateService = (messageData) => {
    return request.put('/message/update', messageData);
};

