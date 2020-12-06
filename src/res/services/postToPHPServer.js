import Api from './API'
import Helper from "../../res/js/Helper.js";

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
    const formData = Helper.fillFormatData("insert" + name, dataj);
    return this.send(formData);
  },

  deleteItem(name, dataj) {
    const formData = new FormData();
    formData.append('command', "delete" + name);
    formData.append('id', dataj);
    return this.send(formData);
  },

  selectItems(name) {
    const formData = new FormData();
    formData.append('command', "select" + name);
    return this.send(formData);
  },


}
