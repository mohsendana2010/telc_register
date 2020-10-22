import Vue from 'vue'
import Router from 'vue-router'
// import Hello from '../components/HelloWorld'
import telcRegisterForm from '../components/TelcRegisterForm'

Vue.use(Router);

// create and export router
const router = new Router({
  routes: [
    // {path: '/', name: 'HelloWorld', component: Hello},
    {path: '/', name: 'Register', component: telcRegisterForm},
    {path: '/register', name: 'Register', component: telcRegisterForm}


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
