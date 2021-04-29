import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper.js";

// "agNumberColumnFilter", 0
//   "agTextColumnFilter", 1
//   "agDateColumnFilter", 2
//   "agSetColumnFilter", 3

// 0"id",1 "archiveNumber", 1"memberNr", 1"firstName", 1"lastName", 3"gender", 2"birthday", 1"email",1 "mobile",
//   1"co",1"streetNr", 1"postCode", 1"place", 1"country", 1"birthCountry", 1"birthCity", 2"examDate",1 "examType", 1"title",
//   1"nativeLanguage", 3"partExam", 1"lastMemberNr", 1"description", 3"accommodationRequest",3 "newsletterSubscribe",
// 1"remarks", 1"passed", 1"grades", 2"registerDate", 1"registerTime"

const state = {
  name: 'TelcMember',
  items: [],
  headers: [],
  editedIndex: -1,
  editedItem: {},
  defaultItem: {},
  fields: [],
  headerFilter: [0, 1, 1, 0, 1, 1, 1, 2, 1, 1,
    1, 1, 1, 1, 1, 1, 1, 2, 1, 1,
    1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 1],
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
    console.log(' telcMemberStore setEditedItem passed: ', dataj.passed);
    if (dataj.passed == 0) dataj.passed = false;
    else dataj.passed = true;
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
  updateItem({dispatch}, dataj) {
    console.log('telc member store update: ', dataj);
    if (state.fields.length === 0) {
      dispatch('fieldsItems');
    }
    const formData = Helper.fillFormatData("update" + state.name, dataj);
    return PHPServer.send(formData);
  },
  deleteItem({state}, dataj) {
    return PHPServer.deleteItem(state.name, dataj);
  },
  selectItems({dispatch}) {
    return PHPServer.selectItems(state.name)
      .then(res => {
        let items = res.data;
        if (items.length > 0) {
          for (let i = 0; i < items.length-1; i++) {
            items[i].row = i + 1;
          }
          state.items = items;
          if (state.fields.length === 0) {
            dispatch('fieldsItems');
          }
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

