import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import App from './App.vue';
import vuetify from './plugins/vuetify';
import Injector from "vue-inject";
import router from './utils/router/index';
import store from "./store";
import { i18n } from "./res/language/i18n.js";
require('./plugins/axios'); //import axios into Vue.prototype;

// import Helper from "./res/js/Helper.js";
import globalComponents from "./GlobalComponents.js";
import "./res/js/Helper.js";


import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const options = {
  // You can set your default options here
  timeout: 0
};

Vue.use(Toast, options);

// process.env.NODE_ENV = 'production';
// console.log(`NODE_ENV: ${process.env.NODE_ENV}`);

Vue.use(Injector);

const moment = require('moment');
require('moment/locale/de');

Vue.use(require('vue-moment'), {
  moment
});

// console.log(Vue.moment().locale()); //de


Vue.config.productionTip = false;


/* HELPER */
// window.AjaxHelper = AjaxHelper; // Delete this when not needed
// window.Helper = Helper; // Delete this when not needed

new Vue({
  vuetify,
  router,
  i18n,
  store,
  globalComponents,
  // Helper,
  icons: {
    iconfont: 'mdi', // default - only for display purposes
  },
  dependencies : ['Helperr'],
  render: h => h(App)
}).$mount('#app')
