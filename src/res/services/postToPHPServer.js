import Api from './API'
import Helper from "../../res/js/Helper.js";
import store from "../../store/index.js";

export default {
  send(credentials) {//  '@/server/command.php'
    return new Promise((resolve, reject) => {
      const formData = credentials;
      formData.append('Authorization', localStorage.getItem('token'));
      if (formData.get('captcha') === 'true' )
      {
        formData.append('captchaCode', store.getters['captcha/getCaptchaCode']);
        formData.append('captchaEncrypt', store.getters['captcha/getCaptchaEncrypt']);
      }

      // return Api().post('/index.php', formData,{ withCredentials: true })
      return Api().post('/index.php', formData,)
        .then(resp => {
          if (formData.get('command') === 'updateTelcMember' )
            console.log('post to php server: ', formData.get('command') , resp);

          resolve(resp);
        })
        .catch(err => {
          reject(err);
        });
    });
  },

  sendCommand(commandName) {
    const formData = new FormData();
    formData.append('command', commandName);
    return this.send(formData);
  },

  saveItem(name, dataj) {
    const formData = Helper.fillFormatData("save" + name, dataj);
    return this.send(formData);
  },

  deleteItem(name, dataj) {
    const formData = new FormData();
    formData.append('command', "delete" + name);
    formData.append('id', dataj);
    return this.send(formData);
  },

  selectItems(name) {
    this.loginVerify();
    return this.sendCommand("select" + name);
    // const formData = new FormData();
    // formData.append('command', "select" + name);
    // return this.send(formData);
  },

  fieldsItems(name) {
    return this.sendCommand("fields" + name);
  },

  headerFilter(name) {
    return this.sendCommand("headerFilter" + name);
  },

  verifyCaptcha(dataj) {
    const formData = Helper.fillFormatData("verifyCaptcha", dataj);
    return this.send(formData);
  },

  loginVerify() {
    return new Promise((resolve) => {
      store.dispatch('Login/loginVerify')
        .then(() => {
          // console.log(' loginVerify in post php server');
          resolve();
        })
    });
  },

  myFunction(name, dataj) {
    const formData = Helper.fillFormatData(dataj.myFunction + name, dataj);
    return this.send(formData);
  },


}
