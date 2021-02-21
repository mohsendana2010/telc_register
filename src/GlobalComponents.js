import Vue from "vue";
/*GLOBAL COMPONENTS */
// import UserName from "./components/userName.vue";
// Vue.component("Greetings", UserName);

import myDataTable from "./components/globalComponents/MyDataTable.vue";
Vue.component("mydatatable", myDataTable);

import myAgGrid from "./components/globalComponents/MyAgGrid";
Vue.component("myaggrid", myAgGrid);

import MyButton from "./components/globalComponents/MyButton.vue";
Vue.component("mybtn", MyButton);

import MySaveButtons from "./components/globalComponents/MySaveGrupButtons";
Vue.component("mysavebtn", MySaveButtons);


import MyWarningDialog from "./components/globalComponents/WarningDialog.vue";
Vue.component("mywarningdialog", MyWarningDialog);

// import TimePicker from "./components/SimpleComponents/TimePicker.vue";
// Vue.component("mytimepicker", TimePicker);

// import TimePicker from "./components/SimpleComponents/TimePicker.vue";
// Vue.component("mytimepicker", TimePicker);

import DatePicker from "./components/globalComponents/DatePicker.vue";
Vue.component("my_date_picker", DatePicker);

import Captcha from "./components/globalComponents/Captcha";
Vue.component("mycaptcha", Captcha);

import MySelectAll from "./components/globalComponents/MySelectAll";
Vue.component("myselectall", MySelectAll);

