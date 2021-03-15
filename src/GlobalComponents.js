import Vue from "vue";
/*GLOBAL COMPONENTS */

import myDataTable from "./components/globalComponents/MyDataTable.vue";
Vue.component("mydatatable", myDataTable);

import MyButton from "./components/globalComponents/MyButton.vue";
Vue.component("mybtn", MyButton);

import MySaveButtons from "./components/globalComponents/MySaveGrupButtons";
Vue.component("mysavebtn", MySaveButtons);

import MyWarningDialog from "./components/globalComponents/WarningDialog.vue";
Vue.component("mywarningdialog", MyWarningDialog);

import DatePicker from "./components/globalComponents/DatePicker.vue";
Vue.component("my_date_picker", DatePicker);

import Captcha from "./components/globalComponents/Captcha";
Vue.component("mycaptcha", Captcha);

import MySelectAll from "./components/globalComponents/MySelectAll";
Vue.component("myselectall", MySelectAll);

