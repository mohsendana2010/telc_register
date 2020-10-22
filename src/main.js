import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import router from './router/index'
import store from "./store";
import { i18n } from "./res/translations/i18n.js";
import Helper from "./res/js/Helper.js";
import globalComponents from "./GlobalComponents.js";

// process.env.NODE_ENV = 'production';
console.log(`NODE_ENV: ${process.env.NODE_ENV}`);

window.axios = require('axios');
const moment = require('moment');
require('moment/locale/de');

Vue.use(require('vue-moment'), {
  moment
});

// console.log(Vue.moment().locale()); //de


Vue.config.productionTip = false;


/* HELPER */
// window.AjaxHelper = AjaxHelper; // Delete this when not needed
window.Helper = Helper; // Delete this when not needed

new Vue({
  vuetify,
  router,
  i18n,
  store,
  globalComponents,
  render: h => h(App)
}).$mount('#app')
