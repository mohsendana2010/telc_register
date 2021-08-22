import PHPServer from "../../res/services/postToPHPServer";
import Helper from "../../res/js/Helper";
import * as fn from './exportFiles';

class Modules {
  //mystate;

  constructor(myName, myTableName) {
    // this.carname = brand;
    this.myName = myName;
    this.myTableName = myTableName;

    this.myFn = fn;
    for (let i = 0; i < this.myFn.length; i++) {
      if (myName == this.myFn[i].default.myName()) {
        this.myTmp = this.myFn[i].default;
        this.myFnAction = this.myTmp.myAction();
        this.myFnMutation = this.myTmp.myMutation();
        this.myFnState = this.myTmp.myState();
        this.myFnGetter = this.myTmp.myGetter();
        break;
      }
    }

  }

  myStates() {
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

    };
    for(var key in this.myFnState) {
      this.state[key] = this.myFnState[key];
    }
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

    };

    this.addMethods(this.getters, this.myFnGetter);
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
            // console.log('cls_modules  SelectItems: ', res);
            let items = res.data;
            if (items.length > 0) {
              for (let i = 0; i < items.length; i++) {
                items[i].row = i + 1;
              }
              state.items = items;
              if (state.headerFilter.length === 0) {
                dispatch('headerFilter');
              }
              if ('formatedItems' in state)
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
            // console.log(' cls_modules headerFilter:', res);
            let tableField = res.data;
            state.headerFilter = tableField;
          })
      },

    };

    this.addMethods(this.actions, this.myFnAction);

    return this.actions;
  }

  // myMutations(state) {
  myMutations() {
    this.mutation = {
      // test() {
      //   let tmpStr = 'salam mohsen jun';
      //   console.log('temp test in mymutations:', tmpStr, state);
      //   return tmpStr;
      // },
    };

    this.addMethods(this.mutation, this.myFnMutation);
    return this.mutation;
  }


  addMethods(methods, object) {

    for (var name in object) {
      methods[name] = object[name];
    }
  }

}


export default Modules;


