import PHPServer from '../../res/services/postToPHPServer';
// import Helper from "../../res/js/Helper";

const state = {
  name: 'Login',
  items: [],
  editedItem: {},
  firstName: "",
  lastName: "",
  token: "",
  loggedIn: false,
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

  // setEditedItem({state}, dataj) {
  //   state.editedItem = dataj;
  // },
  // setEditedIndex({state}, dataj) {
  //   state.editedIndex = dataj;
  // },
  // saveItem({dispatch}, dataj) {
  //   if (state.fields.length === 0) {
  //     dispatch('fieldsItems');
  //   }
  //   return PHPServer.saveItem(state.name, dataj);
  // },
  // deleteItem({state}, dataj) {
  //   return PHPServer.deleteItem(state.name, dataj);
  // },
  // selectItems({dispatch}) {
  //   return PHPServer.selectItems(state.name)
  //     .then(res => {
  //       let items = res.data;
  //       for (let i = 0; i < items.length; i++) {
  //         items[i].row = i + 1;
  //       }
  //       state.items = items;
  //       dispatch('formatedItems');
  //       if (state.fields.length === 0) {
  //         dispatch('fieldsItems');
  //       }
  //     })
  // },
  // fieldsItems() {
  //   return PHPServer.fieldsItems(state.name)
  //     .then(res => {
  //       let tableField = res.data;
  //       state.fields = tableField;
  //       // state.headers = Helper.makeTableHeader(state.name,tableField);
  //       state.headers = Helper.makeAgGridHeader(state.name, tableField, state.headerFilter, state.headerId);
  //     })
  // },
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


