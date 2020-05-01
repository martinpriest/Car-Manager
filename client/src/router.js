import Vue from 'vue';
import Router from 'vue-router';
import Logout from './views/Logout.vue';
import Dashboard from './views/Dashboard.vue';
import Cars from './views/Cars.vue';
import Setting from './views/Setting.vue';
import Raports from './views/Raports.vue';

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Logout',
      component: Logout,
    },
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard
    },
    {
      path: '/cars',
      name: 'Cars',
      component: Cars,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/setting',
      name: 'Setting',
      component: Setting,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/raports',
      name: 'Raports',
      component: Raports,
      meta: {
        requiresAuth: true
      }
    },
  ],
});