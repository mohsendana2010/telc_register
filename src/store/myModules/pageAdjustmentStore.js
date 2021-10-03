 import PHPServer from '../../res/services/postToPHPServer';
 import Helper from "../../res/js/Helper";
const myFunctions = {
  myName(){return 'PageAdjustment'; },
  myState(){
    return {
      adjustment: [],
    }
  },
  myGetter() {
    return{
      getAdjustment: state => state.adjustment,
    }
  },
  myAction() {
    return{
      selectAllAdjustmentByUser({state}) {
        // console.log(' state.adjustment', state.adjustment.length);
        if (state.adjustment.length == 0){
            PHPServer.sendCommand('selectAllAdjustmentByUser' + state.tableName )
              .then((res) => {
                // console.log(' pageAdjustmentStore res: ', res);
                state.adjustment = res.data;
              });
        }
      },

      saveAdjustment({state}, dataj) {
        console.log(' dataj', dataj);
        console.log('find state.adjustment', state.adjustment.find(x => x.page == dataj.page));
        state.adjustment.find(x => x.page == dataj.page).adjustment = dataj.adjustment;
        console.log(' state.adjustment', state.adjustment);
        const formData = Helper.fillFormatData("saveAdjustment" + state.tableName, dataj);
        state.adjustment
        return PHPServer.send(formData);
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