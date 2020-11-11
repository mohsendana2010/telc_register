import Vue from 'vue';
import axios from 'axios'
// import store from '@/store'
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios);

// const token = store.getters['maniApp/getToken'];
// if (token)  axios.default.headers.common['Authorization'] = token;

export default () => {
  return axios.create(
    {
      // withCredentials: true,
      // credentials: 'http://localhost/Diwan%20anmelden/telc_register/server/',
      baseURL: 'http://localhost/telc%20register/telc_register/server',
      headers: {
        // 'Access-Control-Allow-Origin': '*',
        'Accept': 'application/json',
        'Content-Type': 'application/json;charset=utf-8',
        // 'content-type': 'application/x-www-form-urlencoded',
        // "Access-Control-Allow-Origin": "THE_FRONTEND_DOMAIN",
        // 'Content-Type': 'text/plain;charset=utf-8'
        // Authorization: `Bearer ${store.getters['mainApp/getToken']}`,
      }
    }
  )
}
//test
