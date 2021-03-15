import Api from './API'
import Helper from "../../res/js/Helper.js";
import store from "../../store";

export default {
  send(credentials) {//  '@/server/command.php'
    return new Promise((resolve, reject) => {
      const formData = credentials;
      return Api().post('/index.php', formData)
        .then(resp => {
          resolve(resp);
        })
        .catch(err => {
          reject(err);
        });
    });
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
    const formData = new FormData();
    formData.append('command', "select" + name);
    return this.send(formData);
  },

  fieldsItems(name) {
    const formData = new FormData();
    formData.append('command', "fields" + name);
    return this.send(formData);
  },

  verifyCaptcha(dataj) {
    const formData = Helper.fillFormatData("verifyCaptcha", dataj);
    return this.send(formData);
  },

  loginVerify() {
    return new Promise((resolve) => {
      store.dispatch('Login/loginVerify')
        .then(() => {
          console.log(' loginVerify in post to php server');
          resolve();
        })
    });
  },


}
