/*jshint esversion: 8 */
import Vue from 'vue';
import { AlertEvent } from 'bootstrap';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VueCookies from 'vue-cookies';

Vue.use(VueCookies);
VueCookies.config('1d');

Vue.config.productionTip = false;

Vue.component('loading', Loading);
Vue.component('home', require('./views/web/Home.vue'));
Vue.component('register', require('./views/web/Register.vue'));
Vue.component('login', require('./views/web/Login.vue'));

new Vue({ el: '#app' });
