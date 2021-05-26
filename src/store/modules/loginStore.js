import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper";
// import Helper from "../../res/js/Helper";

const state = {
  name: 'Login',
  items: [],
  editedItem: {},
  firstName: "",
  lastName: "",
  token: "",
  loggedIn: false,
  state: '',
};

const getters = {
  getItems: state => state.items,
  getEditedItem: state => state.editedItem,
  getFirstName: state => state.firstName,
  getLastName: state => state.lastName,
  getTocken: state => state.token,

};

const actions = {//dispatch
  login({dispatch}, dataj) {
    const formData = new FormData();
    formData.append('command', "login");
    formData.append('user', dataj.user);
    formData.append('password', dataj.password);
    return new Promise((resolve, reject) => {
      PHPServer.send(formData)
        .then(res => {
          // console.log('res login', res.data.token);
          dispatch('setLocalStorage', res.data);
          resolve(res);
        }).catch(err =>{
        reject(err);
      })
    });
  },
  loginVerify({dispatch}) {
    const formData = new FormData();
    formData.append('command', "loginVerify");
    // formData.append('token', localStorage.getItem('token'));
    return PHPServer.send(formData)
      .then(res => {
        // console.log(' res loginVerify in login store', res.data.token);
        dispatch('setLocalStorage', res.data);
      })
      ;
  },

  logout({dispatch}) {
    let data = {
      firstName: "",
      lastName: "",
      token: "",
      loggedIn: false,
    };
    dispatch('setLocalStorage', data);
  },

  setLocalStorage({state}, data) {
    state.firstName = data.firstName;
    state.lastName = data.lastName;
    state.token = data.token;
    state.loggedIn = data.loggedIn;
    localStorage.setItem('firstName', data.firstName);
    localStorage.setItem('lastName', data.lastName);
    localStorage.setItem('token', data.token);
    localStorage.setItem('loggedIn', String(data.loggedIn));
  },

  forgotPassword({state},dataj) {
    state.state = '';
    console.log(' loginStore newPassword test:::', dataj);
    const formData = Helper.fillFormatData('forgotPassword', dataj);
    return PHPServer.send(formData);


  },
  forgotPasswordd() {
    console.log(' test forgot passworddddd ');
  },
  newPassword() {

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


