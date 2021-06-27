import Vue from 'vue';
import axios from 'axios'
// import store from '@/store'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios);
axios.defaults.withCredentials = true;

// const token = store.getters['maniApp/getToken'];
// if (token)  axios.default.headers.common['Authorization'] = token;

export default () => {
  // console.log(' api create axios token',localStorage.getItem('token'));
  return axios.create(
    {
      // withCredentials: true,
      // credentials: 'http://localhost/Diwan%20anmelden/telc_register/server/',

      baseURL: 'http://localhost/telc%20register/telc_register/server',
      // baseURL: './server',

      headers:{
        // 'Access-Control-Allow-Origin': '*',
        'Accept': 'application/json',
        'Content-Type': 'application/json;charset=utf-8',
        // 'content-type': 'application/x-www-form-urlencoded',
        // "Access-Control-Allow-Headers": "mohsen",
        // "Access-Control-Allow-Origin": "*",
        // 'Content-Type': 'text/plain;charset=utf-8'
        // Authorization: localStorage.getItem('token'),
        // 'X-Requested-With': 'XMLHttpRequest',
        // 'Access-Control-Allow-Credentials': "true",
        // "Cookie": document.cookie,
      }
    }
  )
}
//test
