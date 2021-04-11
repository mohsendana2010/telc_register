
const state = {
  name:'MyAlert',
  text: "Hello, I'm a snackbar in store",
  color: "primary",
  timeout: -1,
  alertShow: false,



};

const getters = {
  getText: state => state.text,
  getColor: state => state.color,
  getTimeout: state => state.timeout,
  getAlertShow: state => state.alertShow,

};

const actions = {//dispatch

  setShowAlert({state},dataj) {
    state.alertShow = dataj;
  },
  setSnackbar({state},dataj) {
    state.text = dataj.text;
    state.color = dataj.color;
    state.timeout = dataj.timeout;
    state.alertShow = dataj.alertShow;
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

