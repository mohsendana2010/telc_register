import PHPServer from '../../res/services/postToPHPServer';
import Helper from "../../res/js/Helper.js";

const state = {
  examTypes: [],
  headers: [
    {
      text: 'language',
      align: 'start',
      sortable: true,
      value: 'language',
    },
    {
      text: 'type',
      align: 'start',
      sortable: true,
      value: 'type',
    },
    {
      text: 'subtype',
      align: 'start',
      sortable: true,
      value: 'subtype',
    },
    {
      text: 'description',
      align: 'start',
      sortable: true,
      value: 'description',
    },
    {text: 'Actions', value: 'actions', sortable: false},
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
  // getExamTypes({state, dispatch}){
  //   if (state.examTypes.length === 0) {
  //     dispatch.selectExamType()
  //       .then(res => {
  //         return res.data;
  //       });
  //   }
  //   else return state.examTypes;
  // },
  getExamTypes: state => state.examTypes,
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
  insertExamType(state, dataj) {
    const formData = Helper.fillFormatData("insertExamType", dataj);
    return PHPServer.send(formData);
  },
  deleteExamType(state, dataj) {
    const formData = new FormData();
    formData.append('command', "deleteExamType");
    formData.append('id', dataj);
    return PHPServer.send(formData);
  },
  selectExamType(){
      const formData = new FormData();
      formData.append('command', 'selectExamType');
      return PHPServer.send(formData)
        .then(res => {
          state.examTypes = res.data;
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

