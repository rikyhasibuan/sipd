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
                                        <th style="text-align: center;">Kegiatan</th>
                                        <th style="text-align: center;">Pagu Anggaran</th>
                                        <th style="text-align: center;">Realisasi Anggaran</th>
                                        <th style="text-align: center;">Sisa Anggaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(v,k) in output_table" :key="k">
                                        <td>{{ v.kegiatan }}</td>
                                        <td style="text-align:right;">{{ v.anggaran | rupiah }}</td>
                                        <td style="text-align:right;">{{ v.serapan | rupiah }}</td>
                                        <td style="text-align:right;">{{ v.sisa | rupiah}}</td>
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
                        <highcharts :options="serapan"></highcharts>
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
            serapan:{},
            output_table:{},

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
                        this.isLoading = false;
                        this.chart_tahun = this.tahun;
                        this.output_table = response.output_table;

                        this.anggaran = {
                            chart: {
                                type: 'bar',
                                height: '50%'
                            },
                            title: {
                                text: 'Pagu Anggaran Tahun '+ this.tahun+''
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Total Pagu'
                                },
                                labels: {
                                    formatter: function() {
                                        if (this.value >= 1E6) {
                                            return (this.value / 1000000).toFixed(0) + ' Jt';
                                        }
                                        return this.value / 1000;
                                    }
                                },
                            },
                            xAxis: {
                                categories: response.kegiatan,
                                title: {
                                    text: null
                                }
                            },
                            series: response.anggaran.anggaran,
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}:</td><td style="padding:0"><b>Rp.{point.y:.1f}</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },

                            plotOptions: {
                                bar: {
                                    dataLabels: {
                                        enabled: true
                                    }
                                }
                            },
                            legend: {
                                enabled: false
                            }
                        }

                        this.serapan = {
                            chart: {
                                type: 'bar',
                                height: '50%'
                            },
                            title: {
                                text: 'Realisasi Anggaran Tahun '+ this.tahun+''
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Total Realisasi Anggaran'
                                },
                                labels: {
                                    formatter: function() {
                                        if (this.value >= 1E6) {
                                            return (this.value / 1000000).toFixed(0) + ' Jt';
                                        }
                                        return this.value / 1000;
                                    }
                                },
                            },
                            xAxis: {
                                categories: response.kegiatan,
                                title: {
                                    text: null
                                }
                            },
                            series: response.serapan.serapan,
                            tooltip: {
                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}:</td><td style="padding:0"><b>Rp.{point.y:.1f}</b></td></tr>',
                                footerFormat: '</table>',
                                shared: true,
                                useHTML: true
                            },

                            plotOptions: {
                                bar: {
                                    dataLabels: {
                                        enabled: true
                                    }
                                }
                            },
                            legend: {
                                enabled: false
                            }
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
