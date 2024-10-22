import { createApp } from 'vue'
import { createStore } from 'vuex'
import router from './router'

import './style.css';
import 'mdb-vue-ui-kit/css/mdb.min.css';
import 'ant-design-vue/dist/reset.css';

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/css/bootstrap-grid.min.css';
import 'bootstrap/dist/css/bootstrap-reboot.min.css';
import 'bootstrap/dist/css/bootstrap-utilities.css'

import Antd from 'ant-design-vue';
import axios from 'axios';
window.axios = axios;

import { VITE_APP_API_URL } from '../variable';
import.meta.env.VITE_APP_API_URL;
// console.log('Đây là biến môi trường: ',VITE_APP_API_URL);

// Create a new store instance.
const store = createStore({
  state () {
    return {
      count: 0
    }
  },
  mutations: {
    increment (state) {
      state.count++
    }
  }
})


import App from './App.vue'
createApp(App)
.provide('apiUrl',VITE_APP_API_URL)
  .use(router)
  .use(store)
  .use(Antd)
  .mount('#app')