import Vue from 'vue';
import App from './App.vue';
import router from './router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// router.beforeEach((to, from, next) => {
//   var requestOptions = {
//     method: 'GET',
//     redirect: 'follow'
//   };
//   if (to.matched.some(record => record.meta.requiresAuth)) {
//     fetch("http://127.0.0.1:8000/user/status", requestOptions)
//       .then(response => response.json())
//       .then((data) => {
//         console.log(data.status)
//         let login = data.status;
//         if (!login) {
//           console.log("Nie zalogowany!!!");
//           next({ name: 'Dashboard' });
//         } else {

//           next({ name: 'Logout' });
//         }
//       })
//       .catch(error => console.log('error', error));
//   }
// });

Vue.config.productionTip = false;
// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
new Vue({
  router,
  render: h => h(App),
}).$mount('#app');