import ElementsPlus from 'element-plus'
import './assets/main.scss'
import 'element-plus/dist/index.css'
import { createApp } from 'vue'
import router from '@/router'
import {createPinia} from "pinia";
import App from './App.vue'
import {createPersistedState} from "pinia-persistedstate-plugin";
import locale from 'element-plus/dist/locale/zh-cn'

const app = createApp(App);
const pinia = createPinia();
const persist = createPersistedState();
pinia.use(persist);
app.use(pinia);
app.use(ElementsPlus,{
    locale:locale,
});
app.use(router);
app.mount('#app')

