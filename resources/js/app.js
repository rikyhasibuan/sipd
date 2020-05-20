/*jshint esversion: 8 */
import Vue from 'vue';
import { ModalEvent, DropdownEvent, AlertEvent } from 'bootstrap/dist/js/bootstrap.min.js';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VueCookies from 'vue-cookies';
import moment from 'moment/moment';
import 'moment/locale/id';
import money from 'v-money';
import accounting from 'accounting';
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import Multiselect from 'vue-multiselect';

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

// Short Date Filtering
Vue.filter('short_moment', function (date) {
    return moment(date).format('DD/MM/YYYY');
});

// Generate Year
Vue.filter('year', function (date) {
    return moment(date).format('YYYY');
});

// Date Filtering
Vue.filter('difference', function (date) {
    const now = moment(new Date());
    const end = moment(new Date(date));

    const duration = moment.duration(end.diff(now));
    let days = duration.asDays();
    let months = duration.asMonths();
    if (parseInt(days) <= 60 && parseInt(days) > 0) {
        return '<span class="badge alert-danger" style="font-size:100%;">' + parseInt(days) + ' Hari</span>';
    } else if (parseInt(days) > 60) {
        return '<span class="badge alert-success" style="font-size:100%;">' + parseInt(months) + ' Bulan</span>';
    } else if (parseInt(days) === 0) {
        return '<span class="badge alert-danger" style="font-size:100%;">Hari Ini</span>';
    } else if (parseInt(days) < 0) {
        return '<span class="badge alert-default" style="font-size:100%;">Kontrak Habis</span>';
    }
});

// Short Date Filtering
Vue.filter('short_difference', function (since, until) {
    const from = moment(new Date(since));
    const end = moment(new Date(until));

    const duration = moment.duration(end.diff(from));
    let days = duration.asDays();
    if (parseInt(days) > 0) {
        return days;
    } else if (parseInt(days) == 0) {
        return 1;
    }
});

// Filter Generate Date
Vue.filter('month', function (month) {
    switch (month) {
        case 1:
            return 'Januari';
        break;
        case 2:
            return 'Februari';
        break;
        case 3:
            return 'Maret';
        break;
        case 4:
            return 'April';
        break;
        case 5:
            return 'Mei';
        break;
        case 6:
            return 'Juni';
        break;
        case 7:
            return 'Juli';
        break;
        case 8:
            return 'Agustus';
        break;
        case 9:
            return 'September';
        break;
        case 10:
            return 'Oktober';
        break;
        case 11:
            return 'November';
        break;
        case 12:
            return 'Desember';
        break;
        default:
            break;
    }
});

// Filter Rupiah
Vue.filter('rupiah', function (amount) {
    return accounting.formatMoney(amount, "", 0, ".", ",");
});

/**
 *  Component Registration
 */
Vue.component('v-alert', require('./components/Alert.vue'));
Vue.component('v-pagination', require('./components/Pagination.vue'));
Vue.component('v-modal', require('./components/Modal.vue'));
Vue.component('loading', Loading);
Vue.component('multiselect', Multiselect);

Vue.component('login', require('./views/Login.vue'));
Vue.component('dashboard', require('./views/Dashboard.vue'));
Vue.component('profile', require('./views/Profile.vue'));

Vue.component('irban-index', require('./views/Irban/Index.vue'));
Vue.component('irban-create', require('./views/Irban/Create.vue'));
Vue.component('irban-update', require('./views/Irban/Update.vue'));

Vue.component('irban-skpd-index', require('./views/IrbanSkpd/Index.vue'));
Vue.component('irban-skpd-create', require('./views/IrbanSkpd/Create.vue'));
Vue.component('irban-skpd-update', require('./views/IrbanSkpd/Update.vue'));

Vue.component('irban-kabkota-index', require('./views/IrbanKabkota/Index.vue'));
Vue.component('irban-kabkota-create', require('./views/IrbanKabkota/Create.vue'));
Vue.component('irban-kabkota-update', require('./views/IrbanKabkota/Update.vue'));

Vue.component('program-index', require('./views/Program/Index.vue'));
Vue.component('program-create', require('./views/Program/Create.vue'));
Vue.component('program-update', require('./views/Program/Update.vue'));

Vue.component('kegiatan-index', require('./views/Kegiatan/Index.vue'));
Vue.component('kegiatan-create', require('./views/Kegiatan/Create.vue'));
Vue.component('kegiatan-update', require('./views/Kegiatan/Update.vue'));

Vue.component('belanja-index', require('./views/Belanja/Index.vue'));
Vue.component('belanja-create', require('./views/Belanja/Create.vue'));
Vue.component('belanja-update', require('./views/Belanja/Update.vue'));

Vue.component('harian-index', require('./views/Harian/Index.vue'));
Vue.component('harian-update', require('./views/Harian/Update.vue'));

Vue.component('akomodasi-index', require('./views/Akomodasi/Index.vue'));
Vue.component('akomodasi-update', require('./views/Akomodasi/Update.vue'));

Vue.component('bbm-index', require('./views/Bbm/Index.vue'));
Vue.component('bbm-update', require('./views/Bbm/Update.vue'));

Vue.component('hargabbm-update', require('./views/HargaBbm/Update.vue'));

Vue.component('bop-index', require('./views/Bop/Index.vue'));
Vue.component('bop-update', require('./views/Bop/Update.vue'));

Vue.component('pegawai-index', require('./views/Pegawai/Index.vue'));
Vue.component('pegawai-create', require('./views/Pegawai/Create.vue'));
Vue.component('pegawai-update', require('./views/Pegawai/Update.vue'));

Vue.component('user-index', require('./views/User/Index.vue'));
Vue.component('user-create', require('./views/User/Create.vue'));
Vue.component('user-update', require('./views/User/Update.vue'));

Vue.component('perangkatdaerah-index', require('./views/PerangkatDaerah/Index.vue'));
Vue.component('perangkatdaerah-create', require('./views/PerangkatDaerah/Create.vue'));
Vue.component('perangkatdaerah-update', require('./views/PerangkatDaerah/Update.vue'));

Vue.component('anggaran-index', require('./views/Anggaran/Index.vue'));
Vue.component('anggaran-create', require('./views/Anggaran/Create.vue'));
Vue.component('anggaran-update', require('./views/Anggaran/Update.vue'));

Vue.component('dinasbop-index', require('./views/DinasBop/Index.vue'));
Vue.component('dinasbop-create', require('./views/DinasBop/Create.vue'));
Vue.component('dinasbop-update', require('./views/DinasBop/Update.vue'));
Vue.component('dinasbop-detail', require('./views/DinasBop/Detail.vue'));

Vue.component('dinasboptim-create', require('./views/DinasBopTim/Create.vue'));
Vue.component('dinasboptim-update', require('./views/DinasBopTim/Update.vue'));
Vue.component('dinasboptim-detail', require('./views/DinasBopTim/Detail.vue'));

Vue.component('dinasbopreviu-create', require('./views/DinasBopReviu/Create.vue'));
Vue.component('dinasbopreviu-update', require('./views/DinasBopReviu/Update.vue'));
Vue.component('dinasbopreviu-detail', require('./views/DinasBopReviu/Detail.vue'));

Vue.component('dinasboppengumpuldata-create', require('./views/DinasBopPengumpulData/Create.vue'));
Vue.component('dinasboppengumpuldata-update', require('./views/DinasBopPengumpulData/Update.vue'));
Vue.component('dinasboppengumpuldata-detail', require('./views/DinasBopPengumpulData/Detail.vue'));

Vue.component('dinasboptimpengumpuldata-create', require('./views/DinasBopTimPengumpulData/Create.vue'));
Vue.component('dinasboptimpengumpuldata-update', require('./views/DinasBopTimPengumpulData/Update.vue'));

Vue.component('dinasbopadministrasi-create', require('./views/DinasBopAdministrasi/Create.vue'));
Vue.component('dinasbopadministrasi-update', require('./views/DinasBopAdministrasi/Update.vue'));
Vue.component('dinasbopadministrasi-detail', require('./views/DinasBopAdministrasi/Detail.vue'));

Vue.component('dinasboptimadministrasi-create', require('./views/DinasBopTimAdministrasi/Create.vue'));
Vue.component('dinasboptimadministrasi-update', require('./views/DinasBopTimAdministrasi/Update.vue'));

Vue.component('dinasbopdriver-create', require('./views/DinasBopDriver/Create.vue'));
Vue.component('dinasbopdriver-update', require('./views/DinasBopDriver/Update.vue'));
Vue.component('dinasbopdriver-detail', require('./views/DinasBopDriver/Detail.vue'));

Vue.component('dinasbopinspektur-create', require('./views/DinasBopInspektur/Create.vue'));
Vue.component('dinasbopinspektur-update', require('./views/DinasBopInspektur/Update.vue'));
Vue.component('dinasbopinspektur-detail', require('./views/DinasBopInspektur/Detail.vue'));

Vue.component('dinasbopsekretaris-create', require('./views/DinasBopSekretaris/Create.vue'));
Vue.component('dinasbopsekretaris-update', require('./views/DinasBopSekretaris/Update.vue'));
Vue.component('dinasbopsekretaris-detail', require('./views/DinasBopSekretaris/Detail.vue'));

Vue.component('dinasbopsupervisi-create', require('./views/DinasBopSupervisi/Create.vue'));
Vue.component('dinasbopsupervisi-update', require('./views/DinasBopSupervisi/Update.vue'));
Vue.component('dinasbopsupervisi-detail', require('./views/DinasBopSupervisi/Detail.vue'));

Vue.component('dinasregular-index', require('./views/DinasRegular/Index.vue'));
Vue.component('dinasregular-create', require('./views/DinasRegular/Create.vue'));
Vue.component('dinasregular-update', require('./views/DinasRegular/Update.vue'));
Vue.component('dinasregular-detail', require('./views/DinasRegular/Detail.vue'));
Vue.component('dinasregular-transportasi', require('./views/DinasRegular/Transportasi.vue'));

Vue.component('report', require('./views/Report.vue'));

Vue.config.productionTip = false;
new Vue().$mount('#app');
