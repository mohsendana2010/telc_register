import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

import timeAccounts from "./server/timeAccounts";
import setup from "./server/setup";

export default {
  namespaced: true,
  state: {
    time: "",
    settings: "",
    logo: "",
    processing: false,
    absences: []
  },
  mutations: {
    processServerTime(state, time) {
      state.time = time;
    },
    setSettings(state, settings) {
      state.settings = settings;
    },
    setLogo(state, logo) {
      state.logo = logo;
    },
    saveSetting(state, val) {
      state.processing = val;
    },
    setAbsences(state, absences) {
      state.absences = absences;
    }
  },
  actions: {
    getServerTime({ commit }) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/getServerTime",
            method: "GET"
          })
          .then(resp => {
            commit("processServerTime", resp.data.currentTime);
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    setTime({ commit }, dateTime) {
      commit("processServerTime", dateTime);
    },
    getLogo({ commit }) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/getLogo",
            method: "GET"
          })
          .then(resp => {
            commit("setLogo", resp.data.U_settingStringData);
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    getSettings({ commit }) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/settings",
            method: "GET"
          })
          .then(resp => {
            commit("setSettings", resp.data);
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    saveSetting({ commit }, setting) {
      commit("saveSetting", true);
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url:
              Vue.prototype.apiUrl +
              "/api/server/settings/" +
              setting.U_settingName,
            data: setting,
            method: "PATCH"
          })
          .then(resp => {
            commit("saveSetting", false);
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    saveAbsences({ commit }, absences) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/saveAbsenceReasons",
            method: "POST",
            data: absences
          })
          .then(resp => {
            commit("setAbsences", absences);
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    getAbsenceReasons({ commit }) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/absences",
            method: "GET"
          })
          .then(resp => {
            commit("setAbsences", resp.data);
            resolve();
          })
          .catch(err => {
            reject(err);
          });
      });
    }
  },
  modules: {
    timeAccounts,
    setup
  },
  getters: {
    serverTime: state => state.time,
    logo: state => state.logo,
    factorAuth: state => state.settings,
    absences: state => state.absences
  }
};
