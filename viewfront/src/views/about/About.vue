<template>
    <div class="container">
        <div class="leftBox">
            <div class="head">
                <img src="./img/tou.png" alt="" />
                <h1>Luojiawei的简历</h1>
            </div>
            <div class="basicInfo">
                <h2 class="leftTitle">基本信息</h2>
                <ul>
                    <li><span>名字：</span>RogaWin(罗佳炜)</li>
                    <li><span>性别：</span>男</li>
                    <li><span>毕业院校：</span>江西理工大学</li>
                    <li><span>博客：</span><a href="https://blog.csdn.net/elderingezez?spm=1000.2115.3001.5343" target="_blank">csdn</a></li>
                    <li><span>GitHub：</span><a href="https://github.com/RogaWin" target="_blank">https://github.com/RogaWin</a></li>
                </ul>
            </div>
            <div class="contact">
                <h2 class="leftTitle">联系方式</h2>
                <ul>
                    <li><span><i class="fa fa-fw fa-phone"></i>电话：</span>17379948860</li>
                    <li><span><i class="fa fa-fw fa-envelope-o"></i>邮箱：</span>2240774934@qq.com</li>
                    <li><span><i class="fa fa-fw fa-qq"></i>QQ：</span>2240774934</li>
                </ul>
            </div>
            <div class="application">
                <h2 class="leftTitle">应聘岗位</h2>
                <p>无</p>
            </div>
            <div class="aboutme">
                我是一位在校大学生，目标找到工作和女朋友。
            </div>
        </div>

        <div class="rightBox">
            <h3 class="rightTitle"><i class="fa fa-fw fa-rocket"></i>项目与工作经验</h3>
            <h4>个人项目</h4>
            <ul class="itemList">
                <li v-for="(project, index) in projects" :key="index">
                    <div class="circle"></div>
                    <h5>{{ project.title }}</h5>
                    <p v-for="(desc, dIndex) in project.descriptions" :key="dIndex">{{ desc }}</p>
                </li>
            </ul>

            <h3 class="rightTitle"><i class="fa fa-fw fa-rocket"></i>专业技能</h3>
            <h4>前端</h4>
            <ul class="itemList">
                <li v-for="(skill, index) in frontendSkills" :key="index">
                    <div class="circle"></div>
                    <h5>{{ skill.title }}</h5>
                    <p v-for="(desc, dIndex) in skill.descriptions" :key="dIndex">{{ desc }}</p>
                </li>
            </ul>

            <h4>后端</h4>
            <ul class="itemList">
                <li v-for="(skill, index) in backendSkills" :key="index">
                    <div class="circle"></div>
                    <h5>{{ skill.title }}</h5>
                    <p v-for="(desc, dIndex) in skill.descriptions" :key="dIndex">{{ desc }}</p>
                </li>
            </ul>
        </div>

        <div class="footer">
            Made with <i class="fa fa-fw fa-heart"></i> by <a href="https://github.com/RogaWin" target="_blank">RogaWin</a>. 我不玩原神
        </div>

        <div class="review" v-if="showReviewModal" @click="hideReview">
            <img :src="reviewImgSrc" id="review-img" alt="证明图片" />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// 项目数据
const projects = ref([
    {
        title: '机器人对战平台',
        descriptions: [
            '机器人对战平台是一个基于人工智能的竞技平台，支持多种机器人对战模式和策略。',
            '技术栈：STM32/USART/UART/SPI/I2C/CAN/FreeRTOS',
            '负责小车的 STM32 芯片开发，包括串口通信、武器系统、防御系统的设计与实现。',
            '开发和优化通信协议，确保系统的稳定性和实时性。',
            '使用 STM32CubeIDE 进行开发，使用 STM32 HAL 和 FreeRTOS 实现系统功能。',
            '进行调试和性能分析，使用 ST-LINK/V2 和 Trace 工具。',
            '使用 RTOS 系统实现低延迟网传摄像头。',
        ],
    },
    {
        title: '牛马点评',
        descriptions: [
            '牛马点评平台是一个用户评价和评分系统，支持用户对产品进行评分和评论。',
            '技术栈：redis/springboot/mysql',
            '开发和迭代评价系统功能，包括评论模块、评分系统和数据分析。',
            '后台管理界面的设计和功能。',
            '优化数据存储和分析，支持高并发用户访问。',
        ],
    },
    // 其他项目...
]);

// 前端技能数据
const frontendSkills = ref([
    {
        title: 'HTML/CSS',
        descriptions: [
            '能够处理一些前端需求',
            '了解 HTML、CSS',
        ],
    },
    {
        title: 'JavaScript',
        descriptions: [
            '了解处理一些前端请求',
            '熟练使用 JS 封装构造函数类插件及组件',
        ],
    },
    // 其他前端技能...
]);

// 后端技能数据
const backendSkills = ref([
    {
        title: 'Spring Boot',
        descriptions: [
            '熟练使用 Spring Boot 框架',
        ],
    },
    {
        title: 'MyBatis/MyBatis-Plus',
        descriptions: [
            '熟悉使用 MyBatis/MyBatis-Plus 对数据库的处理',
            '熟悉使用 MyBatis-X 等工具',
        ],
    },
    // 其他后端技能...
]);

// 模态框控制
const showReviewModal = ref(false);
const reviewImgSrc = ref('');

// 显示模态框
const showReview = (src) => {
    reviewImgSrc.value = src;
    showReviewModal.value = true;
};

// 隐藏模态框
const hideReview = () => {
    showReviewModal.value = false;
};
</script>

<style>
@import "css/style.css";
</style>
