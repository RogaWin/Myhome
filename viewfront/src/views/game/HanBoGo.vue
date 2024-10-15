<template>
  <div id="body1" class="body1" v-if="isGame" @keydown="keydown" @keyup="keyup">
    <img id="pic" src="./picture/小可莉.png" alt="无法显示图片" width="700" height="700"
         style="top: 100px; left: 60px;">
    <img id="guaishou" src="./picture/汉堡.gif" alt="无法显示图片" width="500" height="500">

    <div id="xuetiao1"></div>
    <div id="xuetiao2"></div>

    <!-- 添加背景音乐 -->
    <audio id="background-music" autoplay loop>
      <source src="./vedio/可莉洗脑曲.mp3" type="audio/mpeg">
      <source src="./vedio/可莉洗脑曲.ogg" type="audio/ogg">
      您的浏览器不支持音频播放。
    </audio>
    <audio id="biu-sound" src="./vedio/biubiu.mp3">
      <source src="./vedio/biubiu.mp3" type="audio/mpeg">
      <source src="./vedio/biubiu.ogg" type="audio/ogg">
      您的浏览器不支持音频播放。
    </audio>
    <div id="game-over-modal" v-if="finished" class="modal">
      <div class="modal-content">
        <h2>游戏结束</h2>
        <p>请选择您的操作：</p>
        <el-button type="primary" round @click="goToMainMenu">回到主界面</el-button>
        <el-button type="success" round @click="restartGame">重新开始</el-button>
      </div>
    </div>
  </div>
  <div class="body" v-show="!isGame">
    <h1>请选择你的英雄</h1>
    <div class="shell">
      <div class="card" @click="showModal('琴团长还有事要忙哦，不能去打怪兽~')">
        <div class="box">
          <img src="./picture/琴团长.png"/>
        </div>
        <div class="character">
          <img src="./picture/琴团长.png"/>
        </div>
        <h4>琴团长</h4>
      </div>
      <div class="card" @click="showModal('芭芭rua这么可爱，你忍心让她去打怪兽吗~')">
        <div class="box">
          <img src="./picture/芭芭rua.png"/>
        </div>
        <div class="character">
          <img src="./picture/芭芭rua.png"/>
        </div>
        <h4>芭芭rua</h4>
      </div>
      <div class="card" @click="startGame">
        <div class="box">
          <img src="./picture/可莉.png"/>
        </div>
        <div class="character">
          <img src="./picture/可莉.png"/>
        </div>
        <h4>小可莉</h4>
      </div>
      <div class="card" @click="showModal('刻猫猫：王小美，没有你我怎么活啊！！！（刻猫猫拒绝了你的请求）')">
        <div class="box">
          <img src="./picture/刻猫猫.png"/>
        </div>
        <div class="character">
          <img src="./picture/刻猫猫.png"/>
        </div>
        <h4>刻猫猫</h4>
      </div>
      <div class="card" @click="showModal('王小美睡着了，你不能叫醒她~')">
        <div class="box">
          <img src="./picture/王小美.png"/>
        </div>
        <div class="character">
          <img src="./picture/王小美.png"/>
        </div>
        <h4>王小美</h4>
      </div>
      <div class="card" @click="showModal('堂主正在给别人办葬礼，你不能选她哦~')">
        <div class="box">
          <img src="./picture/胡堂主.png"/>
        </div>
        <div class="character">
          <img src="./picture/胡堂主.png"/>
        </div>
        <h4>堂主</h4>
      </div>
      <div class="card" @click="showModal('你什么实力，居然敢选我脑婆，先成为山里灵活的狗再说')">
        <div class="box">
          <img src="./picture/脑婆.png"/>
        </div>
        <div class="character">
          <img src="./picture/脑婆.png"/>
        </div>
        <h4>脑婆</h4>
      </div>
      <div class="card" @click="showModal('呜呜呜~小草神已经被学院主任抓走了，快去救她QAQ')">
        <div class="box">
          <img src="./picture/小草神.png" alt="无法显示">
        </div>
        <div class="character">
          <img src="./picture/小草神.png" alt="无法显示">
        </div>
        <h4>小草神</h4>
      </div>
    </div>
    <!-- 弹出窗口 -->
    <div id="myModal" class="modalIndex">
      <div class="modal-content-Index">
        <span class="close" @click="closeModal">&times;</span>
        <p id="modalText">这里是弹出内容</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import {onUpdated, ref} from 'vue';

const isGame = ref(false);
const finished = ref(false);

const startGame = ()=>{
    isGame.value=true;
    this.$router.go(0);
}
// 显示模态框并设置内容
function showModal(content) {
  document.getElementById("modalText").innerText = content;
  document.getElementById("myModal").style.display = "flex";
}

// 关闭模态框
function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

// 当用户点击模态框外部时也关闭模态框
window.onclick = function (event) {
  const modal = document.getElementById("myModal");
  if (event.target === modal) {
    closeModal();
  }
}

// 定义玩家类
class people {
  domTop = 200; // 初始垂直位置
  domLeft = 60; // 初始水平位置
  width = 100; // 宽度
  height = 100; // 高度
  stopleft = true; // 左移动标志
  stopright = true; // 右移动标志
  stopup = true; // 上移动标志
  stopdown = true; // 下移动标志
  xueliang = 150; // 生命值
  speed = 5; // 移动速度
  constructor(left, top, width, height) {
    this.domLeft = left
    this.domTop = top
    this.width = width
    this.height = height

  }

  // 移动
  moveleft() {
    this.domLeft -= this.speed
  }

  moveright() {
    this.domLeft += this.speed
  }

  moveup() {
    this.domTop -= this.speed
  }

  movedown() {
    this.domTop += this.speed
  }

  move(img_name, xuetiao_id) {
    if (this.stopleft == false) {
      this.moveleft();
    }
    if (this.stopright == false) {
      this.moveright();
    }
    if (this.stopup == false) {
      this.moveup();
    }
    if (this.stopdown == false) {
      this.movedown();
    }
    // 更新玩家位置
    let boxDom = document.getElementById(img_name); //没有这个的话，是找不到变量的
    boxDom.style.top = this.domTop + "px";
    boxDom.style.left = this.domLeft + "px";

    if (xuetiao_id) {
      // 更新生命条位置
      let xuetiaoDom = document.getElementById(xuetiao_id);
      xuetiaoDom.style.top = this.domTop - 20 + "px"; // 与玩家的垂直位置一致
      xuetiaoDom.style.left = this.domLeft + "px"; // 与玩家的水平位置一致
    }

  }
}

//全局变量moveCount设置为0

class guaishou extends people {
  moveCount = 0;
  xueliang = 250;

  constructor(left, top, width, height) {
    super(left, top, width, height);
    this.speed = 5;
    this.stopleft = false;
    this.stopright = false;
    this.stopup = false;
    this.stopdown = false;
  }

  // 四个标志随机为true而且只有一个标志能为true


  move(img_name, xuetiao_id) {
    let flag;
    if (this.moveCount !== -1) {
      zidanset2.add(guaishou1)
      this.moveCount++;
    }
    if (this.moveCount < 10) {
      // 不超出屏幕边界
    } else if (this.moveCount === 10) {
      flag = Math.floor(Math.random() * 4);
    } else {
      this.moveCount = 0;
    }


    switch (flag) {
      case 0: // 左
        this.stopleft = true;
        this.stopright = false;
        this.stopup = false;
        this.stopdown = false;
        break;
      case 1: // 右
        this.stopleft = false;
        this.stopright = true;
        this.stopup = false;
        this.stopdown = false;
        break;
      case 2: // 上
        this.stopleft = false;
        this.stopright = false;
        this.stopup = true;
        this.stopdown = false;
        break;
      case 3: // 下
        this.stopleft = false;
        this.stopright = false;
        this.stopup = false;
        this.stopdown = true;
        break;
    }

    // 更新怪兽位置
    let boxDom = document.getElementById(img_name);
    boxDom.style.top = this.domTop + "px";
    boxDom.style.left = this.domLeft + "px";

    if (xuetiao_id) {
      // 更新血条位置
      let xuetiaoDom = document.getElementById(xuetiao_id);
      xuetiaoDom.style.top = this.domTop - 20 + "px";
      xuetiaoDom.style.left = this.domLeft + "px";
    }
    // 实际移动逻辑
    if (!this.stopleft && this.domLeft > 0) {
      this.moveleft();
    } else if (this.stopleft && this.domLeft <= 0) {
      this.moveright(); // 碰到左边边界后往右走
    }

    if (!this.stopright && this.domLeft < window.innerWidth - boxDom.offsetWidth - 200) {
      this.moveright();
    } else if (this.stopright && this.domLeft >= window.innerWidth - boxDom.offsetWidth - 200) {
      this.moveleft(); // 碰到右边边界后往左走
    }

    if (!this.stopup && this.domTop > 0) {
      this.moveup();
    } else if (this.stopup && this.domTop <= 0) {
      this.movedown(); // 碰到上边边界后往下走
    }

    if (!this.stopdown && this.domTop < window.innerHeight - boxDom.offsetHeight - 200) {
      this.movedown();
    } else if (this.stopdown && this.domTop >= window.innerHeight - boxDom.offsetHeight - 200) {
      this.moveup(); // 碰到下边边界后往上走
    }
  }

}

// 定义子弹类
class one_zidan {
  domTop = 10; //变量直接这样定义,不用加var,也不用加let
  domLeft = 10;
  arrival_end = 0
  end_left = 900
  end_right = 20
  speed = 15
  para = document.createElement("div");
  //计数器


  // 更新子弹初始位置
  constructor(use_person) {
    this.para.style.position = "absolute";
    this.domLeft = use_person.domLeft;
    this.domTop = use_person.domTop;
    this.end_left = use_person.domLeft + 900;
    this.para.style.width = "20px";
    this.para.style.height = "20px";
    this.para.style.backgroundColor = "red";
    this.para.style.borderRadius = "50%";
  }

  // 运行子弹s
  run(a) {
    // 播放 biu.mp3 音乐
    //console.log(this.para.style.left)
    if (this.domLeft <= this.end_left && a === 1) {
      // var biuSound = document.getElementById("biu-sound").play().catch(function(error) {
      //     console.log("Autoplay failed. Please click to play.");
      // });
      // biuSound.play();
      this.domLeft += this.speed
    } else if (a === 2 && this.domLeft >= this.end_right) {
      var randInt = Math.floor(Math.random() * 31) - 15;
      this.domTop = this.domTop + randInt;
      this.domLeft -= this.speed
    } else {
      this.arrival_end = 1;
      console.log("daoda")
      this.para.style.visibility = "hidden";
    }
    this.para.style.top = this.domTop + "px";
    this.para.style.left = this.domLeft + "px";
    let element = document.getElementById("body1");
    element.appendChild(this.para);
  }

}

// 定义子弹集合类
class zidan_set {
  lst = [] // 存储子弹数组
  constructor() {

  }

  add(use_person) {
    let a = new one_zidan(use_person);
    this.lst.push(a);
  }

  // 运行所有子弹
  all_run(guaishou) {
    for (let i = 0; i < this.lst.length; i++) {
      if (guaishou.width === 100) {
        this.lst[i].run(2); // 获取每一颗子弹
      } else {
        this.lst[i].run(1);
      }
      console.log(guaishou.domTop, guaishou.domLeft, guaishou, this.lst[i].domLeft)
      // 检查子弹是否与敌人相碰
      if (this.lst[i].arrival_end == 1) {
        var temp = this.lst[i]
        this.lst[i] = this.lst[this.lst.length - 1]
        this.lst[this.lst.length - 1] = temp
        this.lst.pop()

      } else if (guaishou.domLeft < this.lst[i].domLeft && this.lst[i].domLeft < guaishou.domLeft + guaishou
          .width) {
        // 子弹如果打到敌人，则隐藏子弹
        if (guaishou.domTop < this.lst[i].domTop && this.lst[i].domTop < guaishou.domTop + guaishou.height) {
          var temp = this.lst[i]
          this.lst[i].para.style.visibility = "hidden";
          this.lst[i] = this.lst[this.lst.length - 1]
          this.lst[this.lst.lengtsh - 1] = temp
          this.lst.pop() // 移除该颗子弹
          console.log(666)
          guaishou.xueliang -= 10 // 减少敌人生命
        }
      }

    }
    if (guaishou.xueliang <= 0) {
      // alert("呜呜呜，你怎么可以伤害汉堡博，游戏结束，都是你害的~~~")
      guaishou1.moveCount = -1;
      guaishou.xueliang = -1;

      endGame();
    }
  }

  print() {
    console.log(this.lst)

  }
}

class xuetiao {

  constructor(people, xuetiao_id) {
    this.xuetiao_id = xuetiao_id;
    let xt = document.getElementById(xuetiao_id); //没有这个的话，是找不到变量的
    // console.log(xuetiao_id)
  }

  refresh(people) {
    // console.log(this.xuetiao_id)
    let xt = document.getElementById(this.xuetiao_id); //没有这个的话，是找不到变量的
    xt.style.width = people.xueliang + "px";
  }
}

// ----------------------------------------上面是js类定义----------------------------
//-----------------------------------------类的实例化区------------------------------
var point1;
var zidan1;
var zidan2;

var zidanset1;
var zidanset2;
var guaishou1;
const createGame = ()=>{
point1 = new people(60, 300, 100, 100); //初始化一个变量
zidan1 = new one_zidan(point1);
zidan2 = new one_zidan(point1);

zidanset1 = new zidan_set();
zidanset2 = new zidan_set();
guaishou1 = new guaishou(850, 200, 250, 250);
}
createGame();
// const destroyGame=()=>{
//   delete (point1);
//   delete (zidan1);
//   delete (zidan2);
//   delete (zidanset1);
//   delete (zidanset2);
//   delete (guaishou1);
// }

// 在游戏结束时调用这个函数
function endGame() {
  finished.value = true; // 设置游戏结束状态
}

// 重新开始游戏的函数
function restartGame() {
  // destroyGame();
    // 这里可以重置游戏相关的变量和状态
      finished.value = false; // 重置游戏状态
      isGame.value = true;
     createGame();
}

// 返回主界面的函数
function goToMainMenu() {
  // 这里可以实现返回主界面的逻辑
  // 比如重定向到主界面
  finished.value = false;
  location.reload();
  isGame.value = false;
}

//zidanset1.add(point1);
var xuetiao2 = new xuetiao(guaishou1, "xuetiao2");
var xuetiao1 = new xuetiao(point1, "xuetiao1");
//console.log(point1.domTop);
// 这里只做了上和左的碰撞校验
// 直接将方法丢给body全局触发
// 一直按住按键也可以一直移动

document.addEventListener('keydown', function (event) {
  if (finished.value) {
    return;
  }

  let boxDom = document.getElementById("boxId");
  console.log(event.key)
  switch (event.key) {
    case 'w': // 上
      point1.stopup = false;
      break;
    case 'd': // 右
      point1.stopright = false;
      break;
    case 's': // 下
      point1.stopdown = false;
      break;
    case 'a': // 左
      point1.stopleft = false;
      break;
    case 'b': // 测试
      zidanset1.add(point1);
      break;
    case 'c': // 测试
      zidanset1.print();
      break;
    default:
      break;
  }
});

document.addEventListener('keyup', function (event) {
  if (finished.value) {
    return;
  }

  switch (event.key) {
    case 'w': // 上
      point1.stopup = true;
      break;
    case 'd': // 右
      point1.stopright = true;
      break;
    case 's': // 下
      point1.stopdown = true;
      break;
    case 'a': // 左
      point1.stopleft = true;
      break;
    default:
      break;
  }
});

//-----------------------------------主循环函数--------------------------------------
function updateTime() {
  // let boxDom = document.getElementById("boxId");   //没有这个的话，是找不到变量的
  // boxDom.style.top = point1.domTop + "px";
  // boxDom.style.left = point1.domLeft + "px";
  // console.log(boxDom.style.top);
  point1.move("pic", "xuetiao1");
  guaishou1.move("guaishou", "xuetiao2");
  //zidan1.run("zidan",5);
  xuetiao2.refresh(guaishou1);
  xuetiao1.refresh(point1);
  zidanset1.all_run(guaishou1);
  zidanset2.all_run(point1)

}

//--------------------------------------主循环------------------------------------
window.onload = function () {
  // 当用户按下任何按键时播放音乐
  document.body.addEventListener('keydown', function () {
    var audio = document.getElementById("background-music").play().catch(function (error) {
      console.log("Autoplay failed. Please click to play.");
    });
    if (audio.paused) {
      audio.play();
    }
  });
  // 每隔1000毫秒（即每秒）执行一次updateTime函数
  setInterval(updateTime, 20);
};
</script>

<style scoped lang="scss">
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.body {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  background-image: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);
  background-size: cover;
}

h1 {
  text-align: center;
  color: white;
  margin-bottom: 20px;
  position: fixed;
  top: 20px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1000;
}

.shell {
  width: 1700px;
  margin: 0 auto;
  height: 750px;
  display: flex;
}

.card {
  flex-basis: 15%;
  position: relative;
  overflow: hidden;
}

.card:not(:nth-child(1)) {
  margin-left: 20px;
}

.card:hover {
  overflow: initial;
}

.box {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  transition: all .1s cubic-bezier(0.165, 0.84, 0.44, 1);
  overflow: hidden;
  border-radius: 10px;
  background-image: linear-gradient(180deg, #a18cd1, #fcaae55c, #141414ce);
}

.box > img {
  object-fit: contain;
  width: 100%;
  height: 100%;
  transform: translate(-50%, 10%) scale(3);
  position: relative;
  //z-index: -1;
}

.card:hover > .box img {
  opacity: 0;
}

.card:hover > .box {
  transform: scaleY(1.5);
  background-image: initial;
  background-color: #e0c6ef;
  z-index: 2;
  cursor: pointer;
}

.card > h4 {
  position: absolute;
  display: block;
  width: 120px;
  text-align: center;
  color: rgba(255, 255, 255, 0.2);
  bottom: 0;
  left: 50%;
  transform: translate(-50%, -35%);
  font-size: 28px;
  z-index: 100;
  transition: .2s;
}

.card:hover h4 {
  color: #fff;
  transform: translate(-50%, 250%);
}

.card:hover .character > img {
  opacity: 1;
}

.card > .character {
  position: absolute;
  top: -100px;
  left: -400px;
  width: 100%;
  height: 100%;
  z-index: 3;
  pointer-events: none;
}

.character > img {
  width: 820px;
  height: 820px;
  object-fit: contain;
  opacity: 0;
  transition: all .3s;
  position: relative;
  z-index: -10;
}

/* 弹出窗口样式 */
.modalIndex {
  display: none; /* 隐藏模态框 */
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.modal-content-Index {
  background-color: white;
  margin: auto;
  padding: 30px;
  border: 3px solid #001aff;
  width: 500px;
  text-align: center;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* 设置页面的基本样式 */
.body1 {
  position: relative;
  /* 使元素相对定位 */
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  background-image: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);
}

.modal {
  position: fixed;
  top: 30px;
  left: 100px;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  text-align: center;
}


#boxId {
  position: absolute;
  /* 绝对定位 */
  top: 60px;
  /* 初始垂直位置 */
  left: 60px;
  /* 初始水平位置 */
  width: 50px;
  /* 宽度 */
  height: 50px;
  /* 高度 */
  border-radius: 50%;
  /* 圆形 */
  background-color: red;
  /* 红色背景 */
}

/* 子弹的样式 */
#zidan {
  position: absolute;
  /* 绝对定位 */
  top: 0;
  /* 初始垂直位置 */
  left: 0;
  /* 初始水平位置 */
  width: 20px;
  /* 宽度 */
  height: 20px;
  /* 高度 */
  border-radius: 50%;
  /* 圆形 */
  background-color: red;
  /* 红色背景 */
}

/* 生命条1的样式 */
#xuetiao1 {
  position: absolute;
  /* 绝对定位 */
  top: 20px;
  /* 初始垂直位置 */
  left: 0;
  /* 初始水平位置 */
  width: 100px;
  /* 宽度 */
  height: 10px;
  /* 高度 */
  background-color: red;
  /* 红色背景 */
}

/* 生命条2的样式 */
#xuetiao2 {
  position: absolute;
  /* 绝对定位 */
  top: 320px;
  /* 初始垂直位置 */
  left: 1250px;
  /* 初始水平位置 */
  width: 250px;
  /* 宽度 */
  height: 40px;
  /* 高度 */
  background-color: red;
  /* 红色背景 */
}

/* 玩家的样式 */
#pic {
  position: absolute;
  /* 绝对定位 */
  top: 60px;
  /* 初始垂直位置 */
  left: 60px;
  /* 初始水平位置 */
  width: 150px;
  /* 宽度 */
  height: 150px;
  /* 高度 */
}

/* 敌人的样式 */
#guaishou {
  position: absolute;
  /* 绝对定位 */
  top: 60px;
  /* 初始垂直位置 */
  left: 500px;
  /* 初始水平位置 */
  width: 250px;
  /* 宽度 */
  height: 250px;
  /* 高度 */
}
</style>