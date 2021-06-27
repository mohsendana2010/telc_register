import Vue from 'vue'
import Router from 'vue-router'
import store from "../../store";

Vue.use(Router);

import menu from '../../components/views/menu'
import login from '../../components/users/MyLogin'
import newPassword from '../../components/users/MyNewPassword'
import Users from '../../components/views/Users'
import telcRegisterForm from '../../components/views/TelcRegisterForm'
import telcMemberSave from '../../components/telcMember/TelcMemberSave'
import telcMember from '../../components/views/TelcMember'
import examType from '../../components/views/ExamType'
import examDate from '../../components/views/ExamDate'

import captcha from '../../components/globalComponents/Captcha'
import session from '../../components/views/Session'
import test from '../../components/views/test'


// create and export router
const router = new Router({
  routes: [
    {path: '/', name: 'Register', component: telcRegisterForm},
    {
      path: '/menu', name: 'Menu', component: menu,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },{
      path: '/telcmembersave', name: 'telcMemberSave', component: telcMemberSave,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {path: '/login', name: 'Login', component: login},
    {path: '/newpassword', name: 'NewPassword', component: newPassword},
    {
      path: '/users', name: 'Users', component: Users,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {path: '/register', name: 'Register', component: telcRegisterForm},
    {
      path: '/telcmember', name: 'telcMember', component: telcMember,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {
      path: '/examType', name: 'ExamType', component: examType,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {
      path: '/examDate', name: 'ExamDate', component: examDate,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {path: '/captcha', name: 'Captcha', component: captcha},
    {
      path: '/session', name: 'Sessions', component: session,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {
      path: '/test', name: 'Test', component: test,
      meta: {
        requiresAuth: false,
        is_admin: true
      }
    },


  ]
});


// ensure authentication is setup
router.beforeEach((to, from, next) => {
  console.log(' from', from.path);
  console.log(' to', to.path);
  if (to.meta.requiresAuth) {
    //login verify
    store.dispatch('Login/loginVerify')
      .then(() => {
          // if loggedin -> next / not loggedin -> go to page login
          if (localStorage.getItem("loggedIn") === "true") {
            return next();
          } else {
            return next("/login");
          }
        }
      );

  }
  // console.log(' from',from);
  // console.log(' next',next);
// auth.ha
//   if (!auth.initialized) {
//     return auth.setup()
//       .then(() => next());
//   }
  return next();
});


// special handling for login / logout path
// eslint-disable-next-line consistent-return
router.beforeEach((to, from, next) => {

  // if (auth.loggedin && to.name === "login") {
  //   return next("/");
  // } else if (!auth.loggedin && to.name !== "login") {
  //   return next("/login");
  // } else if (auth.loggedin && to.path === "/logout") {
  //   auth.logout();
  // }
  return next();
});

export default router;
