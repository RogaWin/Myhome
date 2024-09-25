<template>
    <div class="app">
        <!-- 星星背景 -->
        <div class="stars" v-for="(star, index) in stars" :key="index" :style="star.style"></div>

        <!-- 弹幕组件 -->
        <vue-danmaku
            ref="danmakuRef"
            v-model:danmus="danmus"
            isSuspend="true"
            randomChannel="true"
            useSlot="true"
            loop
            :speed="0"
            :fontSize="16"
            debounce="500"
            :channels="7"
            class="danmu-con">
            <template v-slot:dm="{ index, danmu }">
                <span class="danmu-item"> <el-avatar :src="danmu.img || avatar" size="small" />:{{ danmu.content }}</span>
            </template>
        </vue-danmaku>

        <!-- 控制弹幕的按钮 -->
            <div class="controls">
                <button @click="toHome">返回首页</button>
                <button @click="toggleDanmaku">{{ isDanmakuPlaying ? '暂停弹幕' : '启动弹幕' }}</button>
                <button @click="toggleClearDanmaku">{{ isDanmakuHidden ? '显示弹幕' : '隐藏弹幕' }}</button>
                <button @click="toSend">发送留言</button>
            </div>
        <div class="textarea-container">
            <el-input
                v-if="isSend"
                v-model="textarea"
                style="width: 240px"
                :autosize="{ minRows: 2, maxRows: 4 }"
                type="textarea"
                placeholder="请输入留言"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import vueDanmaku from 'vue3-danmaku';
import avatar from '@/assets/default.png';
import {messageAddService, messageListService} from "@/api/message.js";
import useUserInfoStore from "@/stores/userinfo.js";
import {ElMessage} from "element-plus";
import router from "@/router/index.js";
// 弹幕数据
const danmus = ref([
]);
const textarea = ref('');
// 星星数据
const stars = ref([]);
const danmakuRef = ref(null);
const isDanmakuPlaying = ref(true);
const isDanmakuHidden = ref(false);
let isSend = ref(false);
const toHome =()=>{
    router.push('/home');
}
//获取弹幕数据
const getDanmus = async () =>{
    const res = await messageListService();
    danmus.value = res.data;
}
getDanmus();
const toSend = async() => {
    if(isSend===true){
        //获得用户信息
        const useInfoStore = await useUserInfoStore();
        const user = await useInfoStore.info;
        //存入数据库
        const res = await messageAddService({
            img: user.userPic,
            content: textarea.value
        });
        danmus.value.push({
            img: user.userPic,
            content: textarea.value
        });
        //添加成功信息
        ElMessage.success('留言成功');
    }
    isSend = !isSend;
};

// 创建星星
const createStars = () => {
    for (let i = 0; i < 200; i++) {
        stars.value.push({
            style: {
                left: `${Math.random() * 100}vw`,
                top: `${Math.random() * 100}vh`,
                opacity: Math.random(),
                transform: `scale(${Math.random() * 1.5 + 0.5})`,
                animation: `twinkle ${Math.random() * 2+0.1}s infinite alternate`, // 加入闪烁动画
            },
            brightness: Math.random()
        });
    }
};

// 更新星星亮度
const updateStarBrightness = () => {
    stars.value.forEach(star => {
        star.brightness += (Math.random() * 0.1 - 0.05);
        star.brightness = Math.max(0, Math.min(1, star.brightness));
        star.style.opacity = star.brightness;
    });
};

// 切换弹幕播放状态
const toggleDanmaku = () => {
    if (isDanmakuPlaying.value) {
        pauseDanmaku();
    } else {
        startDanmaku();
    }
};

// 切换弹幕显示状态
const toggleClearDanmaku = () => {
    if (isDanmakuHidden.value) {
        showDanmaku();
    } else {
        clearDanmaku();
    }
};

// 弹幕控制方法
const startDanmaku = () => {
    if (danmakuRef.value) {
        danmakuRef.value.play();
        isDanmakuPlaying.value = true;
    }
};

const pauseDanmaku = () => {
    if (danmakuRef.value) {
        danmakuRef.value.pause();
        isDanmakuPlaying.value = false;
    }
};

const clearDanmaku = () => {
    danmus.value = [];
    isDanmakuHidden.value = true;
};

const showDanmaku = () => {
    danmus.value = [
        { avatar: 'http://a.com/a.jpg', name: 'a', text: 'aaa' },
        { avatar: 'http://a.com/b.jpg', name: 'b', text: 'bbb' }
    ];
    isDanmakuHidden.value = false;
};

onMounted(() => {
    createStars();
    setInterval(updateStarBrightness, 100); // 每 100 毫秒更新一次亮度
});
</script>

<style>
.textarea-container{
    position: absolute; /* 使输入框绝对定位 */
    bottom: 80px; /* 距离底部一定距离，以免覆盖按钮 */
    left: 50%;
    transform: translateX(-50%);
    z-index: 20; /* 确保在按钮上面 */
}
.app {
    position: relative;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    background: url('https://www.nasachina.cn/wp-content/uploads/2024/09/LDN1082_px2048.jpg') no-repeat center center fixed;
    background-size: cover;
}

.stars {
    position: absolute;
    width: 4px;
    height: 4px;
    background-color: white;
    border-radius: 50%;
    animation: twinkle 2s infinite alternate; /* 加入闪烁动画 */
}

.danmu-con {
    width: 100vw;
    height: 100vh;
    position: relative;
    z-index: 10; /* 保证弹幕在星空背景之上 */
}

.danmu-item {
    color: #fff;
    text-shadow:
        0 0 10px rgba(255, 255, 255, 0.5),
        0 0 20px rgba(255, 255, 255, 0.3),
        0 0 5px rgba(255, 196, 0, 0.7); /* 新增发光效果 */
}

.controls {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 20;
    display: flex;
    gap: 10px;
}

button {
    padding: 10px 20px;
    background: linear-gradient(90deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.5));
    border: 1px solid #fff;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
    backdrop-filter: blur(10px);
    transition: background 0.3s, transform 0.3s; /* 添加过渡效果 */
}

button:hover {
    background: linear-gradient(90deg, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.7));
    transform: scale(1.05); /* 鼠标悬停时放大 */
}

@keyframes twinkle {
    0% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}
</style>
