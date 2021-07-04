import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper.js";

// "agNumberColumnFilter", 0
//   "agTextColumnFilter", 1
//   "agDateColumnFilter", 2
//   "agSetColumnFilter", 3
// const fileds = ["id", "session", "date"];

const state = {
  name: 'Session',//change
  tableName: 'TblSession',
  items: [],
  headers: [],
  editedIndex: -1,
  editedItem: {},
  defaultItem: {},
  fields: [],
  headerFilter: [0, 1, 1],//change
  headerId: false,

  formatedItems: [],
};

const getters = {
  getItems: state => state.items,
  getEditedItem: state => state.editedItem,
  getDefaultItem: state => state.defaultItem,
  getEditedIndex: state => state.editedIndex,
  getHeaders: state => state.headers,
  getFields: state => state.fields,

  formatedItems: state => state.formatedItems,

};

const actions = {//dispatch
  setEditedItem({state}, dataj) {
    state.editedItem = dataj;
  },
  setEditedIndex({state}, dataj) {
    state.editedIndex = dataj;
  },
  saveItem({dispatch}, dataj) {
    if (state.fields.length === 0) {
      dispatch('fieldsItems');
    }
    return PHPServer.saveItem(state.tableName, dataj);
  },
  deleteItem({state}, dataj) {
    return PHPServer.deleteItem(state.tableName, dataj);
  },
  selectItems({dispatch}) {
    return PHPServer.selectItems(state.tableName)
      .then(res => {
        console.log('items in session store', res.data);
        let items = res.data;
        for (let i = 0; i < items.length; i++) {
          items[i].row = i + 1;
        }
        state.items = items;
        dispatch('formatedItems');
        if (state.fields.length === 0) {
          dispatch('fieldsItems');
        }
      })
  },
  fieldsItems() {
    return PHPServer.fieldsItems(state.tableName)
      .then(res => {
        let tableField = res.data;
        state.fields = tableField;
        // state.headers = Helper.makeTableHeader(state.name,tableField);
        state.headers = Helper.makeAgGridHeader(state.name, tableField, state.headerFilter, state.headerId);
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

