import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper.js";

const state = {};

const getters = {};

const actions = {//dispatch
  insertExamDate(state, dataj) {
    const formData = Helper.fillFormatData("insertExamDate", dataj);
    return PHPServer.send(formData);
  },
};

const mutations = {//commit

};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};

