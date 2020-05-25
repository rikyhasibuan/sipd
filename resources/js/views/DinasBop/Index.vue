<template>
    <div>
        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-right">
                            <button type="button" v-on:click.prevent="toggle" class="btn btn-info mb-2"><i class="fa fa-search"></i> Form Pencarian</button>
                            <a v-if="access.write === 1" :href="route + '/create'" class="btn btn-success mb-2"><i class="fa fa-plus"></i> Tambah Data</a>
                        </div>
                        <transition name="fade">
                            <div class="card" style="margin-top:50px;" v-show="showForm">
                                <div class="card-body table-responsive">
                                    <form v-on:submit.prevent="fetchData()">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <select v-model="search.program" class="form-control">
                                                    <option value="">Pilih Program</option>
                                                    <option v-for="val in this.program_data" :value="val.id" :key="val.id">{{ val.nama_program }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <select v-model="search.kegiatan" class="form-control">
                                                    <option value="">Pilih Kegiatan</option>
                                                    <option v-for="val in this.kegiatan_data" :value="val.id" :key="val.id">{{ val.nama_kegiatan }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <select v-model="search.belanja" class="form-control">
                                                    <option value="">Pilih Kode Belanja</option>
                                                    <option v-for="val in this.belanja_data" :value="val.id" :key="val.id">{{ val.nama_belanja }}</option>
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
                    <div class="card-body table-responsive">
                        <v-alert :alert="alert"></v-alert>
                        <transition name="fade">
                            <table class="table table-hover table-striped table-bordered table-responsive" v-if="showTable == true">
                                <thead>
                                    <tr>
                                        <th style="width:12%;text-align:center;">Kegiatan</th>
                                        <th style="width:12%;text-align:center;">Belanja</th>
                                        <th style="width:8%;text-align:center;">Waktu</th>
                                        <th style="width:8%;text-align:center;">Penyerapan Anggaran</th>
                                        <th style="width:8%;text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="v in dinasbop" :key="v.id">
                                        <td><a :href="route + '/detail?id=' + v.id">{{ v.kegiatan.nama_kegiatan }}</a></td>
                                        <td>{{ v.belanja.nama_belanja }}</td>
                                        <td style="text-align:center;">{{ v.dari | short_moment }} - {{ v.sampai | short_moment }}</td>
                                        <td style="text-align:right;">Rp.{{ v.total_anggaran | rupiah }}</td>
                                        <td>
                                            <div style="text-align: center;">
                                                <a v-if="(access.update === 1)" :href="route + '/edit?id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
                                                    <i class="fa fa-wrench"></i> Ubah
                                                </a>
                                                <button v-else class="btn btn-sm btn-warning disabled mr-sm-1"><i class="fa fa-wrench"></i> Ubah</button>
                                                <a v-if="(access.delete === 1)" href="#" @click="toggleModal(v.id)"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash-o"></i> Hapus
                                                </a>
                                                <button v-else class="btn btn-sm btn-danger disabled"><i class="fa fa-trash-o"></i> Hapus</button>
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
            dinasbop: {},
            total_penyerapan:0,
            search: {
                kegiatan:'',
                program:'',
                belanja:''
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
            showForm: false,
            showTable: false,
            id:''
        }
    },
    props: ['program_data', 'kegiatan_data', 'belanja_data', 'api', 'route', 'access'],
    methods: {
        toggle() {
            this.showForm = !this.showForm
        },
        clear() {
            this.search.kegiatan = '';
            this.search.program = '';
            this.search.belanja = '';
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
        anggaran_tersedia: function(belanja, tahun) {
            service.postData('./api/ajax/total_anggaran', {'tahun':tahun,'belanja':belanja})
            .then(response => {
                return "<span class='label'>"+ response.total_anggaran +"</span>";
            })
            .catch(error => {
                console.log(error);
            });
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
                this.dinasbop = response.data;
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
            service.deleteData(this.api + '?id=' + id)
            .then(response => {
                if(response.status === 'ok') {
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
        this.fetchData();
    }
};
</script>
