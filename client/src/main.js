import Vue from 'vue';
import App from './App.vue';
import router from './router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import * as VueGoogleMaps from 'vue2-google-maps'

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
Vue.use(VueGoogleMaps, {
  load: {
    key: `${process.env.VUE_APP_GOOGLE_API_KEY}`,
    libraries: 'places',
  },
 
  //// If you intend to programmatically custom event listener code
  //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
  //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
  //// you might need to turn this on.
  // autobindAllEvents: false,
 
  //// If you want to manually install components, e.g.
  //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
  //// Vue.component('GmapMarker', GmapMarker)
  //// then disable the following:
  // installComponents: true,
})
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
new Vue({
  router,
  render: h => h(App),
}).$mount('#app');