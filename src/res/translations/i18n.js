import Vue from "vue";
import VueI18n from "vue-i18n";

import en from "./locales/en";
import de from "./locales/de";
import fa from "./locales/fa";

const Languages= [
  {
    title: "English",
    value: "en"
  },
  {
    title: "German",
    value: "de"
  },
  // {
  //   title: "Farsi",
  //   value: "fa"
  // }
];

const messages = {
  en,
  de,
  fa
};


Vue.use(VueI18n);
export const i18n = new VueI18n({
  locale: "de",
  fallbackLocale: "de",
  messages
});

export const LANGUAGES = Languages;

export default {
  messages
};