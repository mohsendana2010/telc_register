import Vue from "vue";
import VueLocalStorage from "vue-localstorage";
import Languages from "../language/i18n";
import { LANGUAGES } from "../language/i18n";


Vue.use(VueLocalStorage);
const supportedLanguages = Object.getOwnPropertyNames(Languages);

const state = {
  formActive : true,
  language: Vue.localStorage.get("language"),
  languages : LANGUAGES,
};

const getters = {
  language: state => state.language,
  getFormActive: state => state.formActive,

  getLanguages(state){
    return state.languages;
  },
};

const actions = {//dispach
  setLanguage({ commit }, languages) {
    if (typeof languages === "string") {
      commit("SET_LANGUAGE", languages);
    } else {
      const language = supportedLanguages.find(sl =>
        languages.find(l =>
          l.split(new RegExp(sl, "gi")).length - 1 > 0 ? sl : null
        )
      );
      commit("SET_LANGUAGE", language);
    }
  },
  setFormActive({state}, dataj) {
    state.formActive = dataj;
    console.log('formActive:', state.formActive);
  },
};

const mutations = {//commit
  SET_LANGUAGE(state, lang) {
    Vue.localStorage.set("language", lang);
    state.language = lang;
    state.formActive = false;

  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};

// add in  in store / index
// import language from "../res/language/languageStore";

// add in store / index
// modules: {
//   language,
//    ...
// }

