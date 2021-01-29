import PHPServer from '../../res/services/postToPHPServer';

const state = {
  captchaImage: "",
  captchaCode: "",
  captchaEncrypt: "",

};

const getters = {
  getCaptchaImage: state => state.captchaImage,
  getCaptchaCode: state => state.captchaCode,
  getCaptchaEncrypt: state => state.captchaEncrypt,
};

const actions = {//dispatch
  getCaptcha() {
    const formData = new FormData();
    formData.append('command', "getCaptcha" );
    PHPServer.send(formData)
      .then(res => {
        state.captchaImage = res.data.captchaImage;
        state.captchaEncrypt = res.data.captchaEncrypt;
      });
  },
  verifyCaptcha({state},dataj) {
    state.captchaCode = dataj.captchaCode;
    return PHPServer.verifyCaptcha(dataj);
  },
  setCaptchaCode({state},dataj) {
    state.captchaCode = dataj;
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

