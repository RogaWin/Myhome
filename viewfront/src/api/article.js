import request from '@/utlis/request.js'
//文章
export  const articleCategoryListService = () => {
	// const tokenStore = useTokenStore();
	// //再pinia中定义的响应式数据，都不需要token
	// return request.get('/category',{headers: {'Authorization':tokenStore.token}})
	return request.get('/category')
}
//所有文章分类
export const articleCategoryAllListService = () => {
	return request.get('/category/listAll')
}
//文章分类添加
export const articleCategoryAddService = (categoryData) => {
	return request.post('/category',categoryData)
}

//文章分类修改
export const articleCategoryUpdateService = (categoryData) => {
	return request.put('/category',categoryData)
}

//文章分类删除
export const articleCategoryDeleteService = (categoryId) => {
	return request.delete('/category',{params:{id:categoryId}})
}



//文章列表查询
export const articleListService = (params) => {
	return request.get('/article',{params:params})
}


export const articleAddService = (articleData) => {
	return request.post('/article',articleData)
}

export const articleUpdateService = (articleData) => {
	return request.put('/article',articleData)
}
//删除文章
export const articleDeleteService = (categoryId)=>{
	return request.delete('/article',{params:{id:categoryId}})
}

//获得所有已发布的文章
export const articleListAllService = (params) => {
	return request.get('/article/listAll',{params:params})
}

//获得文章阅读量
export const articleViewService = (articleId) => {
	return request.get('/article/views',{params:{id:articleId}})
}

export const articleViewAddService = (articleId) => {
	return request.post(`/article/views?id=${articleId}`); // 在 URL 中添加查询参数
};

//找到top5的文章
export const articleTop5Service = () => {
	return request.get('/article/top5')
}
