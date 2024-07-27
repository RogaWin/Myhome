import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  server: {
    proxy: {
      '/api': {//获取路径中包含了/api的请求
        target: 'http://localhost:6666',//后台服务所在源
        changeOrigin: true,//修改源
        rewrite: (path) => path.replace(/^\/api/, '')
      }
    }
  }
})
