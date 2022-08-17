import 'jollof-admin/theme/demo1/tools/webpack/vendors/global'
import 'jollof-admin/theme/demo1/tools/webpack/scripts'
import './datatables'
import Vuelidate from 'vuelidate'
import Vue from "vue";
import VueNoty from 'vuejs-noty';

import axios from "axios";
import {BootstrapVue} from "bootstrap-vue";

Vue.use(BootstrapVue);
Vue.use(Vuelidate);
Vue.use(VueNoty);

window.Vue = Vue;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

const app = new Vue({
    el: '#app',
});
