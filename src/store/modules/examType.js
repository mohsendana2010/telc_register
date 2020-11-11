import PHPServer from '../../res/services/postToPHPServer';
import Helper from "@/res/js/Helper.js";

const state = {
  examTypes: [],
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
};

const actions = {//dispatch
  insertExamType(state, dataj) {
    const formData = Helper.fillFormatData("insertExamType", dataj);
    return PHPServer.send(formData);
  },
  selectExamType(){
      const formData = new FormData();
      formData.append('command', 'selectExamType');
      return PHPServer.send(formData)
        .then(res => {
          state.examTypes = res.data;
          console.log('store: ',res.data);
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

