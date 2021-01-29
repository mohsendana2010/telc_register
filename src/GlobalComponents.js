import Vue from "vue";
/*GLOBAL COMPONENTS */
// import UserName from "./components/userName.vue";
// Vue.component("Greetings", UserName);

import myDataTable from "./components/simpleComponents/MyDataTable.vue";
Vue.component("mydatatable", myDataTable);

import MyButton from "./components/simpleComponents/MyButton.vue";
Vue.component("mybtn", MyButton);


import MyWarningDialog from "./components/simpleComponents/WarningDialog.vue";
Vue.component("mywarningdialog", MyWarningDialog);

// import TimePicker from "./components/SimpleComponents/TimePicker.vue";
// Vue.component("mytimepicker", TimePicker);

// import TimePicker from "./components/SimpleComponents/TimePicker.vue";
// Vue.component("mytimepicker", TimePicker);

import DatePicker from "./components/simpleComponents/DatePicker.vue";
Vue.component("my_date_picker", DatePicker);

import Captcha from "./components/simpleComponents/Captcha";
Vue.component("mycaptcha", Captcha);

// import switchButton from "./components/SimpleComponents/switchButton"
// Vue.component("myswitchbotton", switchButton);
//
// import colorDialog from "./components/SimpleComponents/colorDialog"
// Vue.component("mycolordialog", colorDialog);

//
// export default class globalComponents {
// }