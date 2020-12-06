import Vue from "vue";
import VueLocalStorage from "vue-localstorage";
import Languages from "../../res/translations/i18n";
import { LANGUAGES } from "../../res/translations/i18n";

Vue.use(VueLocalStorage);
const supportedLanguages = Object.getOwnPropertyNames(Languages);

const state = {
  language: Vue.localStorage.get("language"),
  languages : LANGUAGES,
};

const getters = {
  language: state => state.language,

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
  }
};

const mutations = {//commit
  SET_LANGUAGE(state, lang) {
    Vue.localStorage.set("language", lang);
    state.language = lang;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};


