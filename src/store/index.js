// eslint-disable no-undef
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import language from "../res/language/languageStore";
import Login from "./modules/loginStore";
import captcha from "./modules/captchaStore";


import MyAlert from "./utils/myAlertStore";

// eslint-disable-next-line no-unused-vars
function loadWidget(module) {
  // widget += '.vue'
  console.log("Loaded " + module);
  // return System.import('./widgets/' + widget);
  let path = "../modules/" + module;
  // eslint-disable-next-line no-undef
  return system.import(path);
}

import cls_tileModule from "./utils/cls_tileModule";

let arrayModule = ['ExamType', 'ExamDate', 'TriggerExamType'];
// eslint-disable-next-line no-undef,no-unused-vars
for (var x in arrayModule){
  let x = new cls_tileModule(x, "Tbl" + x);
}

let ExamType = new cls_tileModule("ExamType", "TblExamType");
let ExamDate = new cls_tileModule("ExamDate", "TblExamDate");
let TriggerExamType = new cls_tileModule("TriggerExamType", "TblExamTypeTrigger");
let TelcMember = new cls_tileModule("TelcMember", "TblTelcMember");
let Users = new cls_tileModule("Users", "TblUsers");
let Session = new cls_tileModule("Session", "TblSession");


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