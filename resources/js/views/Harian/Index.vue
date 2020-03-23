<template>
    <div>
        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-right">
                            <button type="button" v-on:click.prevent="toggle" class="btn btn-info mb-2"><i class="fa fa-search"></i> Form Pencarian</button>
                        </div>
                        <transition name="fade">
                            <div class="card" style="margin-top:50px;" v-show="showForm">
                                <div class="card-body">
                                    <form v-on:submit.prevent="fetchData()">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <select v-model="search.kabkota" class="form-control">
                                                    <option value="">Pilih Kabupaten / Kota</option>
                                                    <option v-for="val in this.kabkota_data" v-bind:value="val.id" v-bind:key="val.id">{{ val.nama_kabkota }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-group col-md-4">
                                                <button type="submit" class="btn btn-success mr-sm-2"><i class="fa fa-search"></i> Cari Data</button>
                                                <button type="button" v-on:click.prevent="clear" class="btn btn-info"><i class="fa fa-refresh"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </transition>
                    </div>
                    <div class="card-body">
                        <v-alert :alert="alert"></v-alert>
                        <transition name="fade">
                            <table class="table table-hover table-striped table-bordered" v-if="showTable == true">
                                <thead>
                                    <tr>
                                        <th style="width:20%; text-align:center;">Kabupaten / Kota</th>
                                        <th style="width:15%; text-align:center;">Golongan I</th>
                                        <th style="width:15%; text-align:center;">Golongan II</th>
                                        <th style="width:15%; text-align:center;">Golongan III </th>
                                        <th style="width:15%; text-align:center;">Golongan IV</th>
                                        <th style="width:7%; text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="v in harian" :key="v.id">
                                        <td>{{ v.kabkota.nama_kabkota }}</td>
                                        <td style="text-align:right;">{{ v.gol_1 | rupiah }}</td>
                                        <td style="text-align:right;">{{ v.gol_2 | rupiah }}</td>
                                        <td style="text-align:right;">{{ v.gol_3 | rupiah }}</td>
                                        <td style="text-align:right;">{{ v.gol_4 | rupiah }}</td>
                                        <td>
                                            <div style="text-align: center;" v-if="(access.update === 1) & (access.delete === 1)">
                                                <a :href="route + '/edit?id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
                                                    <i class="fa fa-wrench"></i> Ubah
                                                </a>
                                            </div>
                                            <div style="text-align: center;" v-else>
                                                <button class="btn btn-sm btn-warning disabled mr-sm-1"><i class="fa fa-wrench"></i> Ubah</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </transition>
                        <transition name="fade">
                            <div class="card-footer clearfix">
                                <v-pagination
                                    :pagination="pagination"
                                    v-on:next="nextPage"
                                    v-on:previous="prevPage"
                                    v-if="showTable === true">
                                </v-pagination>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import service from './../../services.js';

export default {
    data: function() {
        return {
            harian: {},
            search: {
                kabkota:''
            },
            alert: {
                error:false,
                empty:false
            },
            pagination: {
                page: 1,
                last:0,
                total:0,
                to:0,
                from:0
            },
            isLoading: false,
            showForm: false,
            showTable: false,
            id:''
        }
    },
    props: ['kabkota_data', 'api','route','access'],
    methods: {
        toggle() {
            this.showForm = !this.showForm
        },
        clear() {
            this.search.kabkota = '';
            this.fetchData();
        },
        nextPage() {
            this.pagination.page++;
            this.fetchData();
        },
        prevPage() {
            this.pagination.page--;
            this.fetchData();
        },
        fetchData() {
            this.isLoading = true;
            let query  = this.generateParams();
            service.fetchData(this.api + '?'+ query + '&page='+ this.pagination.page)
            .then(response => {
                this.renderData(response);
            })
            .catch(error => {
                this.isLoading = false;
                this.alert.error = true;
                console.log(error);
            });
        },
        renderData(response) {
            if (response.total === 0) {
                this.showTable = false;
                this.alert.empty = true;
                this.alert.error = false;
            } else {
                this.showTable = true;
                this.alert.empty = false;
                this.alert.error = false;
                this.harian = response.data;
                this.pagination.last = response.last_page;
                this.pagination.from = response.from;
                this.pagination.to = response.to;
                this.pagination.total = response.total;
            }
            this.isLoading = false;
        },
        generateParams() {
            let queryString = Object.keys(this.search).map(key => key + '=' + this.search[key]).join('&');
            return queryString;
        }
    },
    created() {
        this.isLoading = true;
        this.fetchData();
    }
};
</script>
