import PHPServer from '../../res/services/postToPHPServer';

const state = {};

const getters = {};

const actions = {//dispatch
  insertExamDate(state, dataj) {
    return new Promise((resolve, reject) => {
      const formData = new FormData();
      formData.append('command', 'examDate');
      formData.append('writtenExamDate', dataj.writtenExamDate);
      formData.append('oralExamData', dataj.oralExamData);
      formData.append('registrationDeadline', dataj.registrationDeadline);
      formData.append('lastRegistrationDeadline', dataj.lastRegistrationDeadline);
      formData.append('examTypes', dataj.examTypes);

      PHPServer.send(formData)
        .then(resp => {
          resolve(resp);
        })
        .catch(err => {
          reject(err);
        });
    });
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

