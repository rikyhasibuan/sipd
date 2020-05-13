<template>
    <div>
        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
       <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <transition name="fade">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Jumlah Anggaran</th>
                                        <th>Resapan Anggaran</th>
                                        <th>Sisa Anggaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>5.2.2.15.02</b> - <b>Perjalanan Dinas Dalam Daerah PNS Provinsi</b></td>
                                        <td>Rp.{{ anggaran1 | rupiah }}</td>
                                        <td>Rp.{{ resapan1 | rupiah }}</td>
                                        <td>Rp.{{ sisa1 | rupiah }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>5.2.2.15.03</b> - <b>Perjalanan Dinas Luar Provinsi PNS Provinsi</b></td>
                                        <td>Rp.{{ anggaran2 | rupiah }}</td>
                                        <td>Rp.{{ resapan2 | rupiah }}</td>
                                        <td>Rp.{{ sisa2 | rupiah }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>5.2.2.16.02</b> - <b>Perjalanan Dinas Dalam Daerah PNS Non Provinsi</b></td>
                                        <td>Rp.{{ anggaran3 | rupiah }}</td>
                                        <td>Rp.{{ resapan3 | rupiah }}</td>
                                        <td>Rp.{{ sisa3 | rupiah }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>5.2.2.17.02</b> - <b>Perjalanan Dinas Dalam Daerah Non PNS</b></td>
                                        <td>Rp.{{ anggaran4 | rupiah }}</td>
                                        <td>Rp.{{ resapan4 | rupiah }}</td>
                                        <td>Rp.{{ sisa4 | rupiah }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>5.2.2.17.03</b> - <b>Perjalanan Dinas Luar Provinsi Non PNS</b></td>
                                        <td>Rp.{{ anggaran5 | rupiah }}</td>
                                        <td>Rp.{{ resapan5 | rupiah }}</td>
                                        <td>Rp.{{ sisa5 | rupiah }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <highcharts :options="anggaran"></highcharts>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <highcharts :options="resapanAnggaran"></highcharts>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import service from './../services.js';
import { Chart } from 'highcharts-vue';

export default {
    data: function() {
        return {
            tahun: '',
            chart_tahun: '',
            resapanAnggaran: {},
            anggaran:{},
            anggaran1:0,
            resapan1:0,
            sisa1:0,
            anggaran2:0,
            resapan2:0,
            sisa2:0,
            anggaran3:0,
            resapan3:0,
            sisa3:0,
            anggaran4:0,
            resapan4:0,
            sisa4:0,
            anggaran5:0,
            resapan5:0,
            sisa5:0,
            isLoading: false,
            options:null
        }
    },
    props:['api', 'tahun_data'],
    components: {
        highcharts: Chart
    },
    created() {
        this.isLoading = true;
        this.fetchData();
    },
    mounted() {
        let date = new Date();
        this.tahun = date.getFullYear();
    },
    methods: {
        fetchData() {
            this.isLoading = true;
            service.fetchData(this.api + '?tahun=' + this.tahun)
                .then(
                    response => {
                        this.anggaran1 = response.kodering['5221502']['anggaran'].reduce((a, b) => a + b, 0);
                        this.resapan1 = response.kodering['5221502']['resapan'].reduce((a, b) => a + b, 0);
                        this.sisa1 = response.kodering['5221502']['anggaran'].reduce((a, b) => a + b, 0) - response.kodering['5221502']['resapan'].reduce((a, b) => a + b, 0);

                        this.anggaran2 = response.kodering['5221503']['anggaran'].reduce((a, b) => a + b, 0);
                        this.resapan2 = response.kodering['5221503']['resapan'].reduce((a, b) => a + b, 0);
                        this.sisa2 = response.kodering['5221503']['anggaran'].reduce((a, b) => a + b, 0) - response.kodering['5221503']['resapan'].reduce((a, b) => a + b, 0);

                        this.anggaran3 = response.kodering['5221602']['anggaran'].reduce((a, b) => a + b, 0);
                        this.resapan3 = response.kodering['5221602']['resapan'].reduce((a, b) => a + b, 0);
                        this.sisa3 = response.kodering['5221602']['anggaran'].reduce((a, b) => a + b, 0) - response.kodering['5221602']['resapan'].reduce((a, b) => a + b, 0);

                        this.anggaran4 = response.kodering['5221702']['anggaran'].reduce((a, b) => a + b, 0);
                        this.resapan4 = response.kodering['5221702']['resapan'].reduce((a, b) => a + b, 0);
                        this.sisa4 = response.kodering['5221702']['anggaran'].reduce((a, b) => a + b, 0) - response.kodering['5221702']['resapan'].reduce((a, b) => a + b, 0);

                        this.anggaran5 = response.kodering['5221703']['anggaran'].reduce((a, b) => a + b, 0);
                        this.resapan5 = response.kodering['5221703']['resapan'].reduce((a, b) => a + b, 0);
                        this.sisa5 = response.kodering['5221703']['anggaran'].reduce((a, b) => a + b, 0) - response.kodering['5221703']['resapan'].reduce((a, b) => a + b, 0);

                        this.isLoading = false;
                        this.chart_tahun = this.tahun;
                        this.resapanAnggaran = {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Resapan Anggaran Tahun '+ this.tahun+''
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Rupiah'
                                },
                                labels: {
                                    formatter: function() {
                                        if (this.value >= 1E6) {
                                            return (this.value / 1000000).toFixed(0) + ' Jt';
                                        }
                                        return this.value / 1000;
                                    }
                                }
                            },
                            xAxis: {
                                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                            },
                            series: [
                                {
                                    name: '5.2.2.15.02',
                                    data: response.kodering['5221502']['resapan']
                                },
                                {
                                    name: '5.2.2.15.03',
                                    data: response.kodering['5221503']['resapan']
                                },
                                {
                                    name: '5.2.2.16.02',
                                    data: response.kodering['5221602']['resapan']
                                },
                                {
                                    name: '5.2.2.17.02',
                                    data: response.kodering['5221702']['resapan']
                                },
                                {
                                    name: '5.2.2.17.03',
                                    data: response.kodering['5221703']['resapan']
                                }
                            ]
                        }

                        this.anggaran = {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Anggaran Tahun '+ this.tahun+''
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Rupiah'
                                },
                                labels: {
                                    formatter: function() {
                                        if (this.value >= 1E6) {
                                            return (this.value / 1000000).toFixed(0) + ' Jt';
                                        }
                                        return this.value / 1000;
                                    }
                                }
                            },
                            xAxis: {
                                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                crosshair: true
                            },
                            series: [
                                {
                                    name: '5.2.2.15.02',
                                    data: response.kodering['5221502']['anggaran']
                                },
                                {
                                    name: '5.2.2.15.03',
                                    data: response.kodering['5221503']['anggaran']
                                },
                                {
                                    name: '5.2.2.16.02',
                                    data: response.kodering['5221602']['anggaran']
                                },
                                {
                                    name: '5.2.2.17.02',
                                    data: response.kodering['5221702']['anggaran']
                                },
                                {
                                    name: '5.2.2.17.03',
                                    data: response.kodering['5221703']['anggaran']
                                }
                            ],
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}:</td><td style="padding:0"><b>Rp.{point.y:.1f}</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                        }
                    }
                )
                .catch(error => {
                    this.isLoading = false;
                    console.log(error);
                });
        }
    },
    filters: {
        moment: function (date) {
            return moment(date).format('DD MMMM YYYY');
        },
        date: function (date) {
            return moment(date).format('DD');
        },
        month: function (date) {
            return moment(date).format('MMMM');
        },
        year: function (date) {
            return moment(date).format('YYYY');
        }
    }
};
</script>
