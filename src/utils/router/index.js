import Vue from 'vue'
import Router from 'vue-router'
import store from "../../store";

Vue.use(Router);

const menu = () => import('../../components/views/menu');
const login = () => import('../../components/users/MyLogin');
const newPassword = () => import('../../components/users/MyNewPassword');
const Users = () => import('../../components/views/Users');
const telcRegisterForm = () => import('../../components/views/TelcRegisterForm');
const telcMemberSave = () => import('../../components/telcMember/TelcMemberSave');
const telcMember = () => import('../../components/views/TelcMember');
const examType = () => import('../../components/views/ExamType');
const examDate = () => import('../../components/views/ExamDate');

const captcha = () => import('../../components/globalComponents/Captcha');
const session = () => import('../../components/views/Session');

const triggerExamType = () => import('../../components/views/TriggerExamType');
const modelsView = () => import('../../components/views/ModelsView');

const test = () => import('../../components/views/test');

const DemoPage = () => import('../../components/demo/demoPage');

// import menu from '../../components/views/menu'
// import login from '../../components/users/MyLogin'
// import newPassword from '../../components/users/MyNewPassword'
// import Users from '../../components/views/Users'
// import telcRegisterForm from '../../components/views/TelcRegisterForm'
// import telcMemberSave from '../../components/telcMember/TelcMemberSave'
// import telcMember from '../../components/views/TelcMember'
// import examType from '../../components/views/ExamType'
// import examDate from '../../components/views/ExamDate'

// import captcha from '../../components/globalComponents/Captcha'
// import session from '../../components/views/Session'

// import triggerExamType from '../../components/views/TriggerExamType'
// import modelsView from '../../components/views/ModelsView'

// import test from '../../components/views/test'

// import DemoPage from '../../components/demo/demoPage'

// create and export router
const router = new Router({
  mode: 'history',
  routes: [

    { path: '*', component: test },
    {path: '/', name: 'Register', component: telcRegisterForm},
    { path: '/demo', name: 'Demo', component: DemoPage },
    {
      path: '/menu', name: 'Menu', component: menu,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {
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
      path: '/triggerExamType', name: 'TrigerExamType', component: triggerExamType,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },
    {
      path: '/test/:id', name: 'Test', component: test,
      // redirect: '/session',
      meta: {
        requiresAuth: false,
        is_admin: true
      }
    },
    {
      path: '/modelsViews/:id', name: 'ModelsViews', component: modelsView,
      meta: {
        requiresAuth: true,
        is_admin: true
      }
    },


  ]
});

// /a/b/c
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



/**
 * special handling for login / logout path
 * eslint-disable-next-line consistent-return
 * @param to
 * @param from
 * @param next
 *
 * @return callback next()
 */
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
