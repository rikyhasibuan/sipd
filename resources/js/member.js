/*jshint esversion: 8 */
import Vue from 'vue';
import { ModalEvent, DropdownEvent, AlertEvent } from 'bootstrap/dist/js/bootstrap.min.js';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VueCookies from 'vue-cookies';
import moment from 'moment';
import 'moment/locale/id';
import * as Sentry from '@sentry/browser';
import * as Integrations from '@sentry/integrations';
import money from 'v-money';
import accounting from 'accounting';
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';

// Bugs Reporting
Sentry.init({
    dsn: 'https://017b2bd3537d48c7827106c0c90ec0a1@sentry.io/1542404',
    integrations: [new Integrations.Vue({
        Vue,
        attachProps: true,
        logErrors: true
    })],
});

Vue.use(money, {
    decimal: ',',
    thousands: '.',
    prefix: 'Rp ',
    suffix: '',
    precision: 0,
    masked: true
});

Vue.use(datePicker);
Vue.use(accounting);
Vue.use(VueCookies);

// Component Config
moment.locale('id');
$.extend(true, $.fn.datetimepicker.defaults, {
    icons: {
        time: 'fa fa-clock',
        date: 'fa fa-calendar',
        up: 'fa fa-arrow-up',
        down: 'fa fa-arrow-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-calendar-check',
        clear: 'fa fa-trash-alt',
        close: 'fa fa-times-circle'
    }
});

VueCookies.config('1d');

// Date Filtering
Vue.filter('moment', function (date) {
    return moment(date).format('DD MMMM YYYY');
});
// Filter Rupiah
Vue.filter('rupiah', function (amount) {
    return accounting.formatMoney(amount, "Rp ", 0, ".", ",");
});

Vue.component('v-alert', require('./components/Alert.vue'));
Vue.component('v-pagination', require('./components/Pagination.vue'));
Vue.component('loading', Loading);
Vue.component('member-dashboard', require('./views/member/Dashboard.vue'));
Vue.component('member-pembayaran', require('./views/member/Pembayaran.vue'));
Vue.component('member-profile', require('./views/member/Profile.vue'));
Vue.component('member-pemagangan', require('./views/member/Pemagangan.vue'));
Vue.component('member-penempatan', require('./views/member/Penempatan.vue'));

Vue.config.productionTip = false;

new Vue({ el: '#app' });
