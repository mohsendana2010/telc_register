import Vue from 'vue'
import Router from 'vue-router'

import menu from '../components/views/menu'
import login from '../components/globalComponents/MyLogin'
import Users from '../components/views/Users'
import telcRegisterForm from '../components/views/TelcRegisterForm'
import telcMember from '../components/views/TelcMember'
import examTypeSave from '../components/examType/ExamTypeSave'
import examType from '../components/views/ExamType'
import examDate from '../components/views/ExamDate'

import agGrid from '../components/globalComponents/MyAgGrid'

import captcha from '../components/globalComponents/Captcha'
import test from '../components/views/test'

Vue.use(Router);

// create and export router
const router = new Router({
  routes: [
    {path: '/', name: 'Register', component: telcRegisterForm},
    {path: '/menu', name: 'Menu', component: menu},
    {path: '/login', name: 'Login', component: login},
    {path: '/users', name: 'Users', component: Users},
    {path: '/register', name: 'Register', component: telcRegisterForm},
    {path: '/telcmember', name: 'telcMember', component: telcMember},
    {path: '/examtypesave', name: 'ExamTypeSave', component: examTypeSave},
    {path: '/examType', name: 'ExamType', component: examType},
    {path: '/examDate', name: 'ExamDate', component: examDate},
    {path: '/captcha', name: 'Captcha', component: captcha},
    {path: '/test', name: 'Test', component: test},
    {path: '/aggrid', name: 'AgGrid', component: agGrid},


  ]
});


// ensure authentication is setup
// router.beforeEach((to, from, next) => {
//   if (!auth.initialized) {
//     return auth.setup()
//       .then(() => next());
//   }
//   return next();
// });

// special handling for login / logout path
// eslint-disable-next-line consistent-return
// router.beforeEach((to, from, next) => {
//   if (auth.loggedin && to.name === "login") {
//     return next("/");
//   } else if (!auth.loggedin && to.name !== "login") {
//     return next("/login");
//   } else if (auth.loggedin && to.path === "/logout") {
//     auth.logout();
//   }
//   return next();
// });

export default router;
