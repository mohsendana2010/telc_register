import PHPServer from "../../res/services/postToPHPServer";
import Helper from "../../res/js/Helper";

class Modules {
// eslint-disable-next-line no-unused-vars
//   let carname = '';
   mystate;
  constructor(myName,myTableName) {
    // this.carname = brand;
    this.myName = myName;
    this.myTableName = myTableName;

  }
  present() {
    // let myName = 'ExamType';
    return 'I have a ' + this.carname;
  }




  myState() {
     this.state = {
      name: this.myName,
      tableName: this.myTableName,
      items: [],
      headers: [],
      editedIndex: -1,
      editedItem: {},
      defaultItem: {},
      fields: [],
      headerFilter: [],
      headerId: false,

      formatedItems: [],
    };
      return this.state;
  }

  myGetters() {
    this.getters = {
      getItems: state => state.items,
      getEditedItem: state => state.editedItem,
      getDefaultItem: state => state.defaultItem,
      getEditedIndex: state => state.editedIndex,
      getHeaders: state => state.headers,
      getFields: state => state.fields,

      formatedItems: state => state.formatedItems,

    };
    return this.getters;
  }

  myActions(state) {
    this.actions = {//dispatch
      setEditedItem({state}, dataj) {
        state.editedItem = dataj;
      },
      setEditedIndex({state}, dataj) {
        state.editedIndex = dataj;
      },
      saveItem({dispatch}, dataj) {
        dispatch('h');
        if (state.headerFilter.length === 0) {
          dispatch('headerFilter');
        }
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
          .then((res) => {
            console.log('cls_modules  SelectItems: ', res);
            let items = res.data;
            if (items.length > 0) {
              for (let i = 0; i < items.length; i++) {
                items[i].row = i + 1;
              }
              state.items = items;
              if (state.headerFilter.length === 0) {
                dispatch('headerFilter');
              }
              dispatch('formatedItems');
              if (state.fields.length === 0) {
                dispatch('fieldsItems');
              }
            }
          })
      },
      fieldsItems() {
        return PHPServer.fieldsItems(state.tableName)
          .then(res => {
            // console.log(' cls_modules fieldsItems:', res);
            let tableField = res.data;
            state.fields = tableField;
            state.headers = Helper.makeAgGridHeader(state.name, tableField, state.headerFilter, state.headerId);
          })
      },
      headerFilter() {
        return PHPServer.headerFilter(state.tableName)
          .then(res => {
            console.log(' cls_modules headerFilter:', res);
            let tableField = res.data;
            state.headerFilter = tableField;
          })
      },

      formatedItems() {
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

      test({dispatch}) {
        dispatch('headerFilter');
        // return 'salam';
      },
    };
    return this.actions;
  }

  myMutation(state){
    this.mutation = {
      test() {
        let tmpStr = 'salam mohsen jun';
        console.log('temp test in mymutations:', tmpStr, state);
        return tmpStr;
      },
    };
    return this.mutation;
  }

}


export default Modules;



// const mutation = {//commit
//   test() {
//     let tmpStr = 'salam mohsen jun';
//     console.log('temp test in mymutations:', tmpStr);
//     return tmpStr;
//   },
// };
//
// export const myMutations = mutation;
