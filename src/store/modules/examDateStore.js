import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper";

const moment = require('moment');


// "id", "writingExamDate", "speakingExamData",
//   "registrationDeadline", "lastRegistrationDeadline", "examTypes"
const state = {
  name:'ExamDate',
  items: [],
  headers: [],
  editedIndex: -1,
  editedItem: {},
  defaultItem: {},
  fields: [],

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
        dispatch('formatedItems');
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
        // state.defaultItem = Helper.makedefaultItem(tableField);
        // console.log(' default item', state.defaultItem);
        state.headers = Helper.makeTableHeader(state.name,tableField);
      })
  },
  formatedItems(){
    state.formatedItems =  state.items.map(obj => {
      let rObj = {};
      rObj['text'] = moment(obj.writingExamDate).format("DD.MM.YYYY");
      rObj['value'] = obj.writingExamDate;
      rObj['speakingExamData'] = obj.speakingExamData;
      rObj['registrationDeadline'] = obj.registrationDeadline;
      rObj['lastRegistrationDeadline'] = obj.lastRegistrationDeadline;
      rObj['examTypes'] = obj.examTypes;
      rObj['data'] = obj;
      return rObj;
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

