import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import language from "./modules/language";
import examType from "./modules/examTypeStore";
import examDate from "./modules/examDateStore";

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},

  modules: {
    language,
    examType,
    examDate,
  },
  getters: {
    status: state => state.status


  }
});