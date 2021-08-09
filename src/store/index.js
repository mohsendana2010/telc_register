import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import language from "../res/language/languageStore";
import Login from "./modules/loginStore";
import Users from "./modules/usersStore";
import TelcMember from "./modules/telcMemberStore";
// import ExamType from "./modules/examTypeStore";
// import ExamDate from "./modules/examDateStore";
import captcha from "./modules/captchaStore";
import Session from "./modules/sessionStore";

// import TriggerExamType from './modules/triggerExamTypeStore';


import MyAlert from "./utils/myAlertStore";

// eslint-disable-next-line no-unused-vars
function loadWidget(module){
  // widget += '.vue'
  console.log("Loaded " + module);
  // return System.import('./widgets/' + widget);
  let path = "../modules/" + module;
  // eslint-disable-next-line no-undef
 return system.import (path);
}


import cls_tileModule from "./modules/cls_tileModule";
let ExamType = new cls_tileModule("ExamType","TblExamType");
let ExamDate = new cls_tileModule("ExamDate","TblExamDate");
let TriggerExamType = new cls_tileModule("TriggerExamType","tblExamTypeTrigger");


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