const myFunctions = {
  myName(){return 'ExamType'; },
  myState(){
    return {
      formatedItems: [],
    }
  },
  myGetter() {
    return{
      formatedItems: state => state.formatedItems,
    }
  },
  myAction() {
    return{
      formatedItems({state}) {
        state.formatedItems = state.items.map(obj => {
          let rObj = {};
          rObj['text'] = obj.type + " (" + obj.subtype + ")";
          rObj['value'] = obj.type + " (" + obj.subtype + ")";
          rObj['data'] = obj;
          rObj['description'] = obj.description;
          rObj['language'] = obj.language;
          return rObj;
        })
      },
      test({dispatch, state}) {
        // console.log('func name:', this.test.name);
        console.log('my state', state);
        dispatch('headerFilter');
        // return 'salam';
      }
    }
  },
  myMutation(){
    return {
      testMutation({dispatch, state}) {
        // console.log('func name:', this.test.name);
        console.log('my state in examDate', state);
        dispatch('headerFilter');
        // return 'salam';
      },
    }
  }
};

export default myFunctions;


// import PHPServer from '../../res/services/postToPHPServer';
// import Helper from "../../res/js/Helper.js";
// import {myMutations}  from "./cls_modules";
//import Modules  from "./cls_modules";
// let modules = new Modules("ExamType","TblExamType");
// "agNumberColumnFilter", 0
//   "agTextColumnFilter", 1
//   "agDateColumnFilter", 2
//   "agSetColumnFilter", 3
// const fileds = ["id", "language", "type", "subtype", "description"];
// const state = {
//   name: 'ExamType',
//   tableName: 'TblExamType',
//   items: [],
//   headers: [],
//   editedIndex: -1,
//   editedItem: {},
//   defaultItem: {},
//   fields: [],
//   headerFilter: [0, 1, 1, 1, 1],
//   headerId: false,
//
//   formatedItems: [],
// };
// const state = modules.myState();
// const getters = modules.myGetters();
// const getters = {
//   getItems: state => state.items,
//   getEditedItem: state => state.editedItem,
//   getDefaultItem: state => state.defaultItem,
//   getEditedIndex: state => state.editedIndex,
//   getHeaders: state => state.headers,
//   getFields: state => state.fields,
//
//   formatedItems: state => state.formatedItems,
//
// };
// const actions =  modules.myActions(state);
// const actions = {//dispatch
//   setEditedItem({state}, dataj) {
//     state.editedItem = dataj;
//   },
//   setEditedIndex({state}, dataj) {
//     state.editedIndex = dataj;
//   },
//   saveItem({dispatch}, dataj) {
//     if (state.fields.length === 0) {
//       dispatch('fieldsItems');
//     }
//     return PHPServer.saveItem(state.tableName, dataj);
//   },
//   deleteItem({state}, dataj) {
//     return PHPServer.deleteItem(state.tableName, dataj);
//   },
//   selectItems({dispatch}) {
//     return PHPServer.selectItems(state.tableName)
//       .then((res) => {
//         console.log('examTypeStore SelectItems: ', res);
//         let items = res.data;
//         if (items.length > 0) {
//           for (let i = 0; i < items.length; i++) {
//             items[i].row = i + 1;
//           }
//           state.items = items;
//           dispatch('formatedItems');
//           if (state.fields.length === 0) {
//             dispatch('fieldsItems');
//           }
//         }
//       })
//   },
//   fieldsItems() {
//     return PHPServer.fieldsItems(state.tableName)
//       .then(res => {
//         let tableField = res.data;
//         state.fields = tableField;
//         // state.headers = Helper.makeTableHeader(state.name,tableField);
//         state.headers = Helper.makeAgGridHeader(state.name, tableField, state.headerFilter, state.headerId);
//       })
//   },
//   formatedItems() {
//     state.formatedItems = state.items.map(obj => {
//       let rObj = {};
//       rObj['text'] = obj.type + " (" + obj.subtype + ")";
//       rObj['value'] = obj.type + " (" + obj.subtype + ")";
//       rObj['data'] = obj;
//       rObj['description'] = obj.description;
//       rObj['language'] = obj.language;
//       return rObj;
//     })
//   },
//   test() {
//     let tmpStr = 'salam mohsen jun';
//
//     return tmpModules.present();
//   },
// };
// const mutations = modules.myMutation(state);
// const mutations = {//commit
//   test() {
//     let tmpStr = 'salam mohsen jun';
//     let tmpCar = new modules(tmpStr);
//     console.log('temp test in testView:', tmpCar.present());
//     return tmpCar.present();
//   },
// };
// export default {
//   namespaced: true,
//   state,
//   getters,
//   actions,
//   mutations,
// };