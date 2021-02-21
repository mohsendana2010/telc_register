import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import language from "./modules/language";
import Users from "./modules/usersStore";
import TelcMember from "./modules/telcMemberStore";
import ExamType from "./modules/examTypeStore";
import ExamDate from "./modules/examDateStore";
import captcha from "./modules/captchaStore";


export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},

  modules: {
    language,
    Users,
    TelcMember,
    ExamType,
    ExamDate,
    captcha,
  },
  getters: {
    status: state => state.status


  }
});