function statusTranslator(value) {
  if(typeof value === 'string') {
    switch(value) {
      case 'started': 
        return {start: true, pause: false, continue: true, end: false};
        break;
      case 'paused': 
        return {start: true, pause: true, continue: false, end: false};
        break;
      case 'continued': 
        return {start: true, pause: false, continue: true, end: false};
        break;
      case 'ended': 
        return {start: false, pause: true, continue: true, end: true};
        break;
    } 
  }
  // else if (typeof value === 'Object') {
  //   switch(value) {
  //     case {start: false, pause: true, continue: false, end: true}: 
  //       return 'started';
  //       break;
  //     case {start: true, pause: true, continue: false, end: false}: 
  //       return 'paused';
  //       break;
  //     case {start: true, pause: false, continue: true, end: false}: 
  //       return 'continued';
  //       break;
  //     case {start: false, pause: true, continue: true, end: true}: 
  //       return 'started';
  //       break;
  //   }
  // }
}

export default {
 namespaced: true,
  state: {
    status: {
      start: false,
      pause: true,
      continue: true,
      end: true,
    }
  },

  // this.$store.dispatch('setStatus', payload) should be called on login from user's startEndWork status from database
  
  // payload = {
  //   start: Boolean,
  //   pause: Boolean,
  //   continue: Boolean,
  //   end: Boolean,
  // }

  mutations: {
    setStatus: function(state, payload) {
      state.status = {...state.status, ...payload}
    }
  },
  actions: {
    setStatus: function({commit}, status) {
      // needs an instance of axios
      let config = {
        url: 'https://reqres.in/api/users/2', // address to set user's startEndWork status: ["started", "paused", "continued", ""ended"]
        method: 'GET',
        // headers: {token: JSON.parse(localStorage.getItem('token'))},
        // data: {status: status},
        withCredentials: false,
        timeout: 1000,
      };
      return this._vm.$axios(config)
      .then(res => {
        res.data.resault = true; // for demo
        res.data.resault ? commit("setStatus", statusTranslator(status)): null; // needs to handling errors here 
      }).catch(err => {
        console.log(err); // needs to handling errors here
      })
    }
  },
  getters: {
    getStatus: state => state.status,
  }
};
