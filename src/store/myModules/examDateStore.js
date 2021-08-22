const moment = require('moment');

const myFunctions = {
  myName(){return 'ExamDate'; },
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
     test({dispatch, state}) {
       // console.log('func name:', this.test.name);
       console.log('my state in examDate', state);
       dispatch('headerFilter');
       // return 'salam';
     },
     formatedItems({state}) {
       state.formatedItems = state.items.map(obj => {
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
// import Helper from "../../res/js/Helper";
//
// const moment = require('moment');
//
// // "agNumber", 0
// //   "agText", 1
// //   "agDate", 2
// //   "agSet", 3
// // "id", "writingExamDate", "speakingExamData",
// //   "registrationDeadline", "lastRegistrationDeadline", "examTypes"
// const state = {
//   name: 'ExamDate',
//   tableName: 'TblExamDate',
//   items: [],
//   headers: [],
//   editedIndex: -1,
//   editedItem: {},
//   defaultItem: {},
//   fields: [],
//   headerFilter: [0, 2, 2, 2, 2, 1,1,1],
//   headerId: false,
//
//   formatedItems: [],
// };
//
// const getters = {
//   getItems: state => state.items,
//   getEditedItem: state => state.editedItem,
//   getDefaultItem: state => state.defaultItem,
//   getEditedIndex: state => state.editedIndex,
//   getHeaders: state => state.headers,
//   getFields: state => state.fields,
//
//   formatedItems: state => state.formatedItems,
// };
//
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
//       .then(res => {
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
//         // state.headers = Helper.makeTableHeader(state.name, tableField);
//         state.headers = Helper.makeAgGridHeader(state.name, tableField, state.headerFilter, state.headerId);
//       })
//   },
//   formatedItems() {
//     state.formatedItems = state.items.map(obj => {
//       let rObj = {};
//       rObj['text'] = moment(obj.writingExamDate).format("DD.MM.YYYY");
//       rObj['value'] = obj.writingExamDate;
//       rObj['speakingExamData'] = obj.speakingExamData;
//       rObj['registrationDeadline'] = obj.registrationDeadline;
//       rObj['lastRegistrationDeadline'] = obj.lastRegistrationDeadline;
//       rObj['examTypes'] = obj.examTypes;
//       rObj['data'] = obj;
//       return rObj;
//     })
//   },
// };
//
// const mutations = {//commit
//
// };
//
// export default {
//   namespaced: true,
//   state,
//   getters,
//   actions,
//   mutations,
// };
//
