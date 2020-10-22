import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import language from "./modules/language";

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},

  modules: {
    language,
  },
  getters: {
    status: state => state.status
  }
});