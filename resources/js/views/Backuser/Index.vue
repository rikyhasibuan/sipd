<template>
    <vcl-table v-if="placeholder === true"></vcl-table>
    <div v-else>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header with-border">
                        <div class="pull-right">
                            <button type="button" v-on:click.prevent="toggle" class="btn btn-flat btn-info mb-2"><i class="fa fa-search"></i> Form Pencarian</button>
                            <a v-if="access.write === 1" :href="route + '/create'" class="btn btn-flat btn-primary mb-2"><i class="fa fa-plus"></i> Tambah Data</a>
                        </div>
                        <transition name="fade">
                            <div class="card" style="margin-top:50px;" v-show="showForm">
                                <div class="card-body">
                                    <form class="form-inline" v-on:submit.prevent="fetchData()">
                                        <input type="text" class="form-control mr-sm-2" v-model="q" id="q" placeholder="Nama Perusahaan">
                                        <select v-model="level" class="form-control mr-sm-2">
                                            <option value="">Pilih Level</option>
                                            <option value="2">Operator</option>
                                            <option value="3">Manajemen</option>
                                        </select>
                                        <select v-model="status" class="form-control mr-sm-2">
                                            <option value="">Pilih Status</option>
                                            <option value="0">Aktif</option>
                                            <option value="1">Non Aktif</option>
                                        </select>
                                        <button type="submit" class="btn btn-flat btn-success mr-sm-2"><i class="fa fa-search"></i> Cari Data</button>
                                        <button type="button" v-on:click.prevent="clear" class="btn btn-flat btn-info"><i class="fa fa-refresh"></i> Reset</button>
                                    </form>
                                </div>
                            </div>
                        </transition>
                    </div>
                    <div class="card-body table-responsive">
                        <v-alert :errorAlert=errorAlert :emptyAlert=emptyAlert :deleteAlert=deleteAlert></v-alert>
                        <transition name="fade">
                            <table class="table table-hover table-striped table-bordered" v-if="showTable == true">
                                <thead>
                                    <tr>
                                        <th style="width:15%; text-align: center;">Username</th>
                                        <th style="width:30%; text-align: center;">Nama</th>
                                        <th style="width:10%; text-align: center;">Level</th>
                                        <th style="width:10%; text-align: center;">Status</th>
                                        <th style="width:15%; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="v in user" :key="v.id">
                                        <td>{{ v.username }}</td>
                                        <td>{{ v.nama }}</td>
                                        <td>
                                            <span v-if="v.level == 2">Operator</span>
                                            <span v-else-if="v.level == 3">Manajemen</span>
                                            <span v-else>Administrator</span>
                                        </td>
                                        <td>
                                            <span v-if="v.status == 1">Aktif</span>
                                            <span v-else-if="v.status == 0">Non Aktif</span>
                                        </td>
                                        <td>
                                            <div style="text-align: center;" v-if="(access.update === 1) & (access.delete === 1)">
                                                <a :href="route + '/edit?id=' + v.id" class="btn btn-flat btn-sm btn-warning">
                                                    <i class="fa fa-wrench"></i> Ubah
                                                </a>
                                                &nbsp;
                                                <a href="#" @click="toggleModal(v.id)" data-toggle="modal" data-target="#modal"
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
                        <transition name="fade">
                            <div class="modal" id="modal" tabindex="-1" role="dialog" v-if="showModal" @close="showModal = false">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda Akan Menghapus Data Ini, Teruskan?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-flat btn-success" @click.prevent="deleteData(id)">Ya</button>
                                            <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </transition>

                    </div>
                    <div class="card-footer">
                        <transition name="fade">
                            <v-pagination
                                :pageNumber=pageNumber
                                :lastPage=lastPage
                                :to=to
                                :from=from
                                :totalData=totalData
                                v-on:next="nextPage"
                                v-on:previous="prevPage"
                                v-if="showTable === true">
                            </v-pagination>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import service from './../../../services.js';
import { VclTable } from 'vue-content-loading';
import Pagination from './../../Components/Pagination';
import Alert from './../../Components/Alert';

export default {
    data: function() {
        return {
            user: {},
            level: '',
            status:'',
            q:'',
            id: '',
            showTable: true,
            showModal: false,
            errorAlert: false,
            deleteAlert: false,
            emptyAlert: false,
            placeholder: true,
            pageNumber: 1,
            lastPage: 0,
            totalData:0,
            to:0,
            from:0,
            showForm: false
        }
    },
    props: ['api','route','access'],
    components: {
        VclTable,
        'v-pagination':Pagination,
        'v-alert':Alert
    },
    methods: {
        toggle() {
            this.showForm = !this.showForm
        },
        clear() {
            this.level = '';
            this.status = '';
            this.q = '';
            this.fetchData();
        },
        nextPage() {
            this.pageNumber++;
            this.fetchData();
        },
        prevPage() {
            this.pageNumber--;
            this.fetchData();
        },
        toggleModal(id) {
            this.showModal = true;
            this.id = id;
        },
        fetchData() {
            this.$Progress.start();
            service.fetchData(this.api + '?status='+this.status+'&level='+ this.level +'&q='+ this.q +'&page='+ this.pageNumber)
                .then(response => {
                    this.$Progress.finish();
                    this.placeholder = false;
                    this.renderData(response);
                })
                .catch(error => {
                    this.placeholder = false;
                    this.$Progress.failed();
                    this.errorAlert = true;
                    console.log(error);
                });
        },
        renderData(response) {
            if (response.total === 0) {
                this.showTable = false;
                this.emptyAlert = true;
                this.errorAlert = false;
            } else {
                this.showTable = true;
                this.emptyAlert = false;
                this.errorAlert = false;
                this.user = response.data;
                this.lastPage = response.last_page;
                this.from = response.from;
                this.to = response.to;
                this.totalData = response.total;
            }
        },
        deleteData(id) {
            service.deleteData(this.api + '?id=' + id)
            .then(response => {
                if(response.status === 'OK') {
                    this.showModal = false;
                    $('#modal').modal('hide');
                    this.fetchData();
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' })
                    this.deleteAlert = true;
                    setTimeout(() => this.deleteAlert=false, 5000);
                }
            }).catch(error => {
                this.showModal = false;
                $('#modal').modal('hide');
                this.deleteAlert = false;
                this.errorAlert = true;
                this.fetchData();
                window.scroll({ top: 0, left: 0, behavior: 'smooth' })
                console.log(error);
            });
        }
    },
    created() {
        this.placeholder = true;
        this.$Progress.start();
    },
    mounted() {
        this.fetchData();
    }
};
</script>
