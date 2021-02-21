import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper.js";

const state = {
  name:'Users',
  items: [],
  headers: [],
  editedIndex: -1,
  editedItem: {},
  defaultItem: {},
  fields: [],

};

const getters = {
  getItems: state => state.items,
  getEditedItem: state => state.editedItem,
  getDefaultItem: state => state.defaultItem,
  getEditedIndex: state => state.editedIndex,
  getHeaders: state => state.headers,
  getFields: state => state.fields,

};

const actions = {//dispatch
  setEditedItem({state},dataj){
    state.editedItem = dataj;
  },
  setEditedIndex({state},dataj){
    state.editedIndex = dataj;
  },
  saveItem({dispatch},dataj) {
    if (state.fields.length === 0) {
      dispatch('fieldsItems');
    }
    return PHPServer.saveItem(state.name, dataj);
  },
  deleteItem({state},dataj) {
    return PHPServer.deleteItem(state.name,dataj);
  },
  selectItems({dispatch}){
    return PHPServer.selectItems(state.name)
      .then(res => {
        state.items = res.data;
        if (state.fields.length === 0) {
          dispatch('fieldsItems');
        }
      })
  },
  fieldsItems() {
    return PHPServer.fieldsItems(state.name)
      .then(res => {
        let tableField = res.data;
        state.fields = tableField;
        state.headers = Helper.makeTableHeader(state.name,tableField);
      })
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

