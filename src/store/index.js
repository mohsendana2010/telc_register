import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import language from "./modules/language";
import TelcMember from "./modules/telcMemberStore";
import ExamType from "./modules/examTypeStore";
import ExamDate from "./modules/examDateStore";
import captcha from "./modules/captcha";


export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},

  modules: {
    language,
    TelcMember,
    ExamType,
    ExamDate,
    captcha,
  },
  getters: {
    status: state => state.status


  }
});