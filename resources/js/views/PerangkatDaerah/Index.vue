<template>
    <div>
        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <form class="form" v-on:submit.prevent="fetchData()">
                            <div class="row">
                                <div class="form-group col-md-4 col-xs-12">
                                    <input type="text" class="form-control mb-2" v-model="search.query" placeholder="Nama Perangkat Daerah" id="query">
                                </div>
                                <div class="form-group col-md-4 col-xs-6">
                                    <button type="submit" class="btn btn-flat btn-success mb-2">
                                        <i class="fa fa-search"></i> <span class="hidden-xs hidden-sm">Cari Data</span>
                                    </button>
                                    <button type="button" v-on:click.prevent="clear" class="btn btn-flat btn-info mb-2">
                                        <i class="fa fa-refresh"></i> <span class="hidden-xs hidden-sm">Reset</span>
                                    </button>
                                </div>
                                <div class="form-group col-md-4 col-xs-6">
                                    <a v-if="access.write === 1" :href="route + '/create'" class=" btn btn-flat btn-primary pull-right">
                                    <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">Tambah Data</span></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="box-body table-responsive">
                        <v-alert :alert="alert"></v-alert>
                        <transition name="fade">
                            <table class="table table-hover table-striped table-bordered" v-if="showTable == true">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Nama Perangkat Daerah</th>
                                        <th style="text-align: center;">Alamat</th>
                                        <th style="text-align: center;">No Telp</th>
                                        <th style="text-align: center;">Kota</th>
                                        <th style="text-align: center;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="skpd in skpds" :key="skpd.id">
                                        <td style="width:30%;">{{ skpd.nama_skpd }}</td>
                                        <td style="width:20%;">{{ skpd.alamat }}</td>
                                        <td style="width:10%;">{{ skpd.kontak }}</td>
                                        <td style="width:10%;">{{ skpd.kota }}</td>
                                        <td style="width:15%;">
                                            <div style="text-align: center;" v-if="(access.update === 1) & (access.delete === 1)">
                                                <a :href="route + '/edit?id=' + skpd.id" class="btn btn-flat btn-sm btn-warning"><i class="fa fa-wrench"></i> Ubah</a>
                                                &nbsp;
                                                <a href="#" @click="toggleModal(skpd.id)" data-toggle="modal" data-target="#modal"
                                                    class="btn btn-flat btn-sm btn-danger">
                                                        <i class="fa fa-trash-o"></i> Hapus
                                                </a>
                                            </div>
                                            <div style="text-align: center;" v-else>
                                                <button class="btn btn-flat btn-sm btn-warning disabled"><i class="fa fa-wrench"></i> Ubah</button>
                                                &nbsp;
                                                <button class="btn btn-flat btn-sm btn-danger disabled"><i class="fa fa-trash-o"></i> Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </transition>

                        <transition name="fade"><v-modal :id="id" @delete="deleteData"></v-modal></transition>
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
            skpds: {},
            search: {
                query:''
            },
            alert: {
                error:false,
                empty:false,
                delete:false
            },
            pagination: {
                page: 1,
                last:0,
                total:0,
                to:0,
                from:0
            },
            isLoading: false,
            showTable: false,
            id:'',
            usernip:''
        }
    },
    props: ['action','api','route','access'],
    methods: {
        clear() {
            this.search.query = '';
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
        toggleModal(id) {
            $("#deletemodal").modal('show');
            this.id = id;
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
                this.skpds = response.data;
                this.pagination.last = response.last_page;
                this.pagination.from = response.from;
                this.pagination.to = response.to;
                this.pagination.total = response.total;
            }
            this.isLoading = false;
        },
        generateParams() {
            return Object.keys(this.search).map(key => key + '=' + this.search[key]).join('&');
        },
        deleteData(id) {
            service.deleteData(this.api + '?nip='+this.usernip+'&id=' + id)
            .then(response => {
                if(response.status === 'OK') {
                    this.alert.delete = true;
                    $('#deletemodal').modal('hide');
                    this.fetchData();
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(() => this.alert.delete=false, 5000);
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                $('#deletemodal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                this.fetchData();
                console.log(error);
            });
        }
    },
    created() {
        this.isLoading = true;
        this.usernip = this.$cookies.get('nip');
    },
    mounted() {
        this.fetchData();
    }
};
</script>
