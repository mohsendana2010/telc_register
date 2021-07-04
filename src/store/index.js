import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import language from "../res/language/languageStore";
import Login from "./modules/loginStore";
import Users from "./modules/usersStore";
import TelcMember from "./modules/telcMemberStore";
import ExamType from "./modules/examTypeStore";
import ExamDate from "./modules/examDateStore";
import captcha from "./modules/captchaStore";
import Session from "./modules/sessionStore";

import TriggerExamType from './modules/triggerExamTypeStore';


import MyAlert from "./utils/myAlertStore";


export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},

  modules: {
    language,
    Login,
    Users,
    TelcMember,
    ExamType,
    ExamDate,
    captcha,
    Session,
    TriggerExamType,

    MyAlert
  },
  getters: {
    status: state => state.status


  }
});