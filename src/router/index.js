import Vue from 'vue'
import Router from 'vue-router'

import telcRegisterForm from '../components/views/TelcRegisterForm'
import examTypeSave from '../components/examType/ExamTypeSave'
import examType from '../components/views/ExamType'
import examDate from '../components/views/ExamDate'

Vue.use(Router);

// create and export router
const router = new Router({
  routes: [
    {path: '/', name: 'Register', component: telcRegisterForm},
    {path: '/register', name: 'Register', component: telcRegisterForm},
    {path: '/examtypesave', name: 'ExamTypeSave', component: examTypeSave},
    {path: '/examtype', name: 'ExamType', component: examType},
    {path: '/examDate', name: 'ExamDate', component: examDate},


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
