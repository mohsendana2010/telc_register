
import PHPServer from '../../res/services/postToPHPServer';
import { i18n } from "../../res/translations/i18n.js";

const state = {
  name:'ExamType',
  items: [],
  headers: [
    {
      text: i18n.t( 'examType.language'),
      align: 'start',
      sortable: true,
      value: 'language',
      width: "1%"
    },
    {
      text: 'type',
      align: 'start',
      sortable: true,
      value: 'type',
      width: "1%"
    },
    {
      text: 'subtype',
      align: 'start',
      sortable: true,
      value: 'subtype',
      width: "2%"
    },
    {
      text: 'description',
      align: 'start',
      sortable: true,
      value: 'description',
      width: "90%"
    },
    {text: 'Actions', value: 'actions', sortable: false, width: "2%"},
  ],
  editedIndex: -1,
  editedItem: {
    language: "Deutsch",
    type: "",
    subtype: "",
    description: "",
  },
  defaultItem: {
    language: "Deutsch",
    type: "",
    subtype: "",
    description: "",
  },
};

const getters = {
  // getItems({state, dispatch}){
  //   if (state.items.length === 0) {
  //     dispatch.selectExamType()
  //       .then(res => {
  //         return res.data;
  //       });
  //   }
  //   else return state.items;
  // },
  getItems: state => state.items,
  getEditedItem: state => state.editedItem,
  getDefaultItem: state => state.defaultItem,
  getEditedIndex: state => state.editedIndex,
  getHeaders: state => state.headers,

};

const actions = {//dispatch
  setEditedItem({state},dataj){
    state.editedItem = dataj;
  },
  setEditedIndex({state},dataj){
    state.editedIndex = dataj;
  },
  saveItem({state},dataj) {
    return PHPServer.saveItem(state.name, dataj);
  },
  deleteItem({state},dataj) {
    return PHPServer.deleteItem(state.name,dataj);
  },
  selectItems(){
    return PHPServer.selectItems(state.name)
      .then(res => {
        state.items = res.data;
        // console.log('store selectExamType: ',res.data);
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

