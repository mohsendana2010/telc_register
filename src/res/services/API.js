import Vue from 'vue';
import axios from 'axios'
// import store from '@/store'
// import VueAxios from 'vue-axios'

Vue.use( axios);

// const token = store.getters['maniApp/getToken'];
// if (token)  axios.default.headers.common['Authorization'] = token;

export default () => {
  return axios.create(
    {
      // withCredentials: true,
      // credentials: 'http://localhost/Diwan%20anmelden/telc_register/server/',
      // origin: 'http://localhost/Diwan%20anmelden/telc_register/server/',
      // 'http://localhost/Diwan%20anmelden/telc_register/server
      baseURL: '../server',
      headers: {
        // 'Access-Control-Allow-Origin': '*',
        'Accept': 'application/json',
        // 'Content-Type': 'application/json',
        'content-type': 'application/x-www-form-urlencoded'
        // 'Content-Type': 'text/plain;charset=utf-8'
        // Authorization: `Bearer ${store.getters['mainApp/getToken']}`,
      }
    }
  )
}