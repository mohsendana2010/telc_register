import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default {
  namespaced: true,
  actions: {
    getUpdateInfos({ commit }) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/setup/",
            method: "GET"
          })
          .then(resp => {
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    createTable({ commit }, table) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/setup/createTable",
            method: "POST",
            data: table
          })
          .then(resp => {
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    createField({ commit }, fieldObject) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/setup/createField",
            method: "POST",
            data: fieldObject
          })
          .then(resp => {
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    },
    createData({ commit }, dataObject) {
      return new Promise((resolve, reject) => {
        Vue.prototype
          .$http({
            url: Vue.prototype.apiUrl + "/api/server/setup/createData",
            method: "POST",
            data: dataObject
          })
          .then(resp => {
            resolve(resp);
          })
          .catch(err => {
            reject(err);
          });
      });
    }
  },
  modules: {},
  getters: {}
};
