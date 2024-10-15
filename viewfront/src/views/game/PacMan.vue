<template>
  <div class="body" @click="">
    <div class="main">
      <div class="streak"></div>
      <div class="help" tabindex="0">
        ?
        <div v-for="i in finished" :key="i" class="shengming">
          <img src="./picture/001.jpg" />
        </div>
      </div>
      <div class="help-window">
        <h1>How to Play</h1>
        <p><strong>Click/tap</strong> or press <strong>[spacebar]</strong> to change the color of the jello until it
          matches the color of the box it’s about to land on.</p>
        <section>
          <figure><span class="red"></span> &#8594; <span class="yellow"></span><br>&#8593;<span></span><span></span>&#8595;
            <span class="ascii-arrow">——&gt;</span><br><span class="blue"></span> &#8592; <span class="green"></span>
          </figure>
          <figure>
            <div class="box blue"></div>
            <div class="jello red"></div>
          </figure>
        </section>
        <p>+1 point each matching land and back to zero if missed. The higher the streak, the faster the jello will
          jump. See how many you can get in a row!</p>
      </div>
      <div class="jello-hitbox">
        <div class="jello"></div>
      </div>
      <div class="boxes">
        <div class="box"></div>
        <div class="box"></div>
      </div>

      <div class="click-area"></div>
    </div>
  </div>
  <div id="game-over-modal" v-if="finished <= 0" class="modal">
    <div class="modal-content">
      <h2>游戏结束，你把牛牛害鼠了啦~</h2>
      <p>都鼠腻害的</p>
      <el-button type="success" round @click="restartGame">重新开始</el-button>
    </div>
  </div>
</template>

<script setup>
import {ScaleToOriginal} from "@element-plus/icons-vue";
import {ref} from 'vue';
const finished = ref(4);

window.addEventListener("load", game);

function game() {
  var root = document.querySelector(":root"),
      main = document.querySelector(".main"),
      streakCounter = document.querySelector(".streak"),
      jelloHitbox = document.querySelector(".jello-hitbox"),
      jello = document.querySelector(".jello-hitbox > .jello"),
      boxes = document.querySelectorAll(".boxes > .box"),//跳台变色
      colors = ["red", "yellow", "green", "blue"],
      streak = 0,
      compDur = window.getComputedStyle(root),
      compDurVal = compDur.getPropertyValue("--dur"),
      dur = (compDurVal.substr(0, compDurVal.length - 1) * 1000),
      minDur = dur / 2,
      chooseColor = function () {
        return Math.floor(Math.random() / 0.25);
      },
      curColor = chooseColor(),
      prevMatchColor = curColor,
      nextMatchColor = chooseColor(),
      rerun = function () {
        main.classList.remove("run");
        void main.offsetWidth;
        main.classList.add("run");
        root.style.setProperty("--dur", (dur / 1000) + "s");
      },
      cycleColor = function () {
        ++curColor;
        if (curColor == colors.length) {
          curColor = 0;
        }
        jello.className = "jello " + colors[curColor];
      },
      checkColorMatch = function () {
        if (curColor == nextMatchColor) {
          ++streak;
          dur -= 10;
          if (dur < minDur) {
            dur = minDur;
          }
          streakCounter.innerHTML = streak;
        } else {
          endGame();
          streak = 0;
          dur = 2000;
          streakCounter.innerHTML = "";
        }

        prevMatchColor = nextMatchColor;
        nextMatchColor = chooseColor();

        boxes[0].className = "box " + colors[prevMatchColor];

        boxes[1].className = "box " + colors[nextMatchColor];

        rerun();
        setTimeout(checkColorMatch, dur);
      };

  main.classList.add("run");
  jello.classList.add(colors[curColor]);
  boxes[0].classList.add(colors[prevMatchColor]);
  boxes[1].classList.add(colors[nextMatchColor]);

  console.log("boxes:" + boxes);
  for (let b in boxes) {
    if (b < boxes.length) {
      boxes[b].classList.add(colors[chooseColor()]);
    }
  }

  setTimeout(checkColorMatch, dur);

  document.querySelector(".click-area").addEventListener("click", cycleColor);
  document.addEventListener("keydown", function (e) {
    if (e.keyCode == 32) {
      cycleColor();
    }
  });
}

// 在游戏结束时调用这个函数
function endGame() {
  finished.value -= 1; // 设置游戏结束状态
}

// 重新开始游戏的函数
function restartGame() {
  // destroyGame();
    // 这里可以重置游戏相关的变量和状态
      finished.value = 3; // 重置游戏状态
}

</script>

<style scoped>
*, *:before, *:after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  -webkit-tap-highlight-color: transparent;
}

.help, .help-window, .streak {
  z-index: 1;
}

:root {
  --dur: 2s;
  font-size: calc(10px + 1vmin);
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

.body {
  height: 100%;
  background: #333;
  font: 1em Hind, Helvetica, sans-serif;
  line-height: 1.5;
}

.shengming {
  margin: 10px; /* 给左上角留一些边距 */
}

.shengming img {
  width: 50px; /* 设置图片宽度 */
  height: 50px; /* 设置图片高度 */
  border-radius: 50%; /* 使图片圆形 */
  object-fit: cover; /* 保持图片比例 */
}

.main {
  background: #9ab;
  margin: auto;
  overflow: hidden;
  position: relative;
  width: 100%;
  height: 100%;
}

h1 {
  font-size: 2em;
  line-height: 1.5;
  margin-bottom: 0.75em;
  text-align: center;
}

p {
  margin-bottom: 1.5em;
}

section {
  margin: 0 auto 1.5em auto;
  width: 8em;
}

figure, figure > span {
  vertical-align: middle;
}

figure {
  display: inline-table;
  margin-right: -3px;
  min-width: 2em;
  height: 4.5em;
  position: relative;
}

figure > span {
  border-radius: 50%;
  display: inline-block;
  min-width: 1em;
  height: 1em;
}

button {
  position: relative;
}

.help, .help-window, .streak {
  z-index: 1;
}

div {
  position: relative; /* 修改为相对定位，减少绝对定位导致的重叠问题 */
}

/* help */
.help {
  display: flex; /* 使用 Flexbox */
  background-color: transparent;
  border: 0;
  cursor: pointer;
  opacity: 0.5;
  font-size: 3.5em;
  line-height: 1.25;
  top: 0.25em;
  left: 0.25em;
  width: 1.25em;
  height: 1.25em;
  transition: opacity 0.15s linear;
  text-align: center;
}

.help:hover, .help:focus {
  opacity: 1;
  outline: 0;
}

/* 改进帮助窗口的显示和隐藏 */
.help-window {
  background-color: rgba(255, 255, 255, 0.9);
  border-radius: 1em;
  margin: auto;
  padding: 0.75em;
  top: 40%;
  left: 10%;
  transform: translate(-50%, -50%);
  width: 90%;
  max-width: 20em;
  height: 100%;
  max-height: 25em;
  transition: opacity 0.3s ease-out;
  opacity: 0;
  visibility: hidden;
}

.help:focus ~ .help-window {
  opacity: 1;
  visibility: visible;
}

.help:focus ~ .click-area {
  opacity: 0.5;
}

/* jello */
.jello-hitbox, .box {
  left: 50%;
}

.jello-hitbox {
  margin: -4em 0 0 -4em;
  bottom: 6em;
  width: 8em;
  height: 8em;
}

.jello {
  background: radial-gradient(1em 1em at 37% 40%, black 45%, transparent 50%),
  radial-gradient(1em 1em at 63% 40%, black 45%, transparent 50%),
  radial-gradient(100% 200% at 50% 0, transparent 0.65em, black 0.75em, black 47%, transparent 50%) 50% 64% / 2.5em 1em;
  background-repeat: no-repeat;
  background-color: #aaa;
  border-radius: 0.75em;
  box-shadow: 0 0 0 0.75em rgba(255, 255, 255, 0.4) inset;
  transition: background-color 0.15s linear;
  transform-origin: 50% 100%;
  width: 100%;
  height: 100%;
}

figure > .box, figure > .jello {
  transform: scale(0.25, 0.25);
}

figure > .jello {
  transform-origin: 0 0;
  width: 8em;
  height: 8em;
}

figure > .box {
  transform-origin: 50% 100%;
}

/* boxes */
.boxes, .box {
  display: flex;
  bottom: 0;
}

.boxes {
  width: 100%;
}

.box {
  background-color: #777;
  border-radius: 0.5em;
  margin-left: -3em;
  width: 6em;
  height: 6em;
}

.box:last-of-type {
  left: 150%;
}

/* colors */
.red {
  background-color: #f44;
}

.yellow {
  background-color: #fc4;
}

.green {
  background-color: #8c8;
}

.blue {
  background-color: #48f;
}

/* other */
.ascii-arrow {
  transform: rotate(-35deg);
  transform-origin: 0 50%;
}

.click-area {
  background-color: #000;
  opacity: 0;
  width: 100%;
  height: 100%;
}

.streak {
  position: absolute; /* 绝对定位 */
  font-size: 4em;
  text-align: center;
  width: 100%;
}

/* animations */
.run > .jello-hitbox {
  animation: jump calc(var(--dur) / 2) cubic-bezier(.2, .45, .65, .99) 2 alternate;
}

.run > .jello-hitbox > .jello {
  animation: squish var(--dur) ease-out;
}

.run > .boxes {
  animation: scroll var(--dur) linear;
}

@keyframes jump {
  from, 4% {
    transform: translateY(100px);
  }
  to {
    transform: translateY(-12em);
  }
}

@keyframes squish {
  from, 40%, to {
    transform: scale(1, 1);
  }
  8% {
    transform: scale(1.5, 0.5);
  }
  16% {
    transform: scale(0.75, 1.25);
  }
  24% {
    transform: scale(1.25, 0.75);
  }
  32% {
    transform: scale(0.875, 1.125);
  }
}

@keyframes scroll {
  from, 8% {
    transform: translateX(0);
  }
  to {
    transform: translateX(-100%);
  }
}

/* devanagari */
@font-face {
  font-family: 'Hind';
  font-style: normal;
  font-weight: 400;
  src: url('./font/5aU69_a8oxmIdGh4BCOz.woff2') format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB;
}

/* latin-ext */
@font-face {
  font-family: 'Hind';
  font-style: normal;
  font-weight: 400;
  src: url('./font/5aU69_a8oxmIdGd4BCOz.woff2') format('woff2');
  unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}

/* latin */
@font-face {
  font-family: 'Hind';
  font-style: normal;
  font-weight: 400;
  src: url('./font/5aU69_a8oxmIdGl4BA.woff2') format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
</style>