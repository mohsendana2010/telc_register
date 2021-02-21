import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper.js";

// "agNumberColumnFilter", 0
//   "agTextColumnFilter", 1
//   "agDateColumnFilter", 2
//   "agSetColumnFilter", 3

// 0"id", 1"memberNr", 1"firstName", 1"lastName", 3"gender", 2"birthday", 1"email",1 "mobile",
//   1"co",1"streetNr", 1"postCode", 1"place", 1"country", 1"birthCountry", 1"birthCity", 2"examDate",1 "examType", 1"title",
//   1"nativeLanguage", 3"partExam", 1"lastMemberNr", 1"description", 3"accommodationRequest",3 "newsletterSubscribe"


const state = {
  name: 'TelcMember',
  items: [],
  headers: [],
  editedIndex: -1,
  editedItem: {},
  defaultItem: {},
  fields: [],
  headerFilter: [0, 1, 1, 1, 3, 2, 1, 1,
    1, 1, 1, 1, 1, 1, 1, 2, 1, 1,
    1, 3, 1, 1, 3, 3],
  headerId: false,
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
    return PHPServer.saveItem(state.name, dataj);
  },
  deleteItem({state}, dataj) {
    return PHPServer.deleteItem(state.name, dataj);
  },
  selectItems({dispatch}) {
    return PHPServer.selectItems(state.name)
      .then(res => {
        let items = res.data;
        for (let i = 0; i < items.length; i++) {
          items[i].row = i + 1;
        }
        state.items = items;
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

