<template>
    <div style="margin-top:25px;">
        <transition name="fade">
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                    <tr>
                        <td style="width:15%;"><b>Program</b></td>
                        <td style="width:85%;">{{ dinasbop.program.nama_program }}</td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><b>Kegiatan</b></td>
                        <td style="width:85%;">{{ dinasbop.kegiatan.nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><b>Belanja</b></td>
                        <td style="width:85%;">{{ dinasbop.belanja.nama_belanja }}</td>
                    </tr>
                </tbody>
            </table>
        </transition>
        <div style="margin-top:25px;"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <a v-if="access.write === 1" :href="route + '/inspektur/create?dinasbop=' + dinasbop.id" class="btn btn-success mb-2"><i class="fa fa-plus"></i> Tambah Data</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <v-alert :alert="alert"></v-alert>
                <!-- tampil inspektur -->
                <transition name="fade">
                    <table class="table table-hover table-striped table-bordered" v-if="showTable == true">
                        <thead>
                            <tr>
                                <th style="width:25%;text-align:center;">Dasar & Tujuan</th>
                                <th style="width:10%;text-align:center;">Nomor dan Tanggal</th>
                                <th style="width:10%;text-align:center;">Nama</th>
                                <th style="width:10%;text-align:center;">Rincian Biaya</th>
                                <th style="width:15%;text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="v in dinasbopinspektur" :key="v.id">
                                <td style="vertical-align:middle;">
                                    <b>DASAR</b> : <br>
                                    <div v-if="v.dasar.length > 1">
                                        <ul style="margin-left:-25px;">
                                        <li v-for="(d,v) in v.dasar" :value="d" :key="v">{{ d }}</li>
                                        </ul>
                                    </div>
                                    <div v-else>
                                        {{ v.dasar[0] }}
                                    </div>
                                    <br>
                                    <b>TUJUAN</b> : <br>
                                    <div v-if="v.tujuan.length > 1">
                                        <ul style="margin-left:-25px;">
                                        <li v-for="d in v.tujuan" :value="d" :key="d">{{ d }}</li>
                                        </ul>
                                    </div>
                                    <div v-else>
                                        {{ v.tujuan[0] }}
                                    </div>
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    Nomor : <b>{{ v.nomor_sp }}</b>
                                    <br>
                                    Tanggal : {{ v.tgl_sp | moment }}
                                    <br>
                                    {{ v.dari | moment }} s.d {{ v.sampai | moment }}
                                </td>
                                <td style="vertical-align:middle;text-align:center;">
                                    {{ v.inspektur.nama }}
                                </td>
                                <td style="text-align: center; vertical-align:middle;">
                                    {{ v.inspektur.hari }} hari x Rp.{{ v.inspektur.biaya | rupiah }} = Rp.{{ v.inspektur.total | rupiah }}
                                </td>
                                <td style="text-align: center; vertical-align:middle;">
                                    <div style="text-align: center;" v-if="(access.update === 1) & (access.delete === 1)">
                                        <a :href="route + '/inspektur/edit?dinasbop='+ dinasbop.id +'&id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
                                            <i class="fa fa-wrench"></i> Ubah
                                        </a>
                                        <a href="#" @click="toggle_modal(v.id)"
                                            class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash-o"></i> Hapus
                                        </a>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="#" @click="print_sp(v.id)">Surat Perintah</a>
                                                    <a class="dropdown-item" href="#" @click="print_spd(v.id)">Surat Perjalanan Dinas (SPD)</a>
                                                    <a class="dropdown-item" href="#" @click="print_rbpd(v.id)">Rincian Biaya Perjalanan Dinas</a>
                                                    <a class="dropdown-item" href="#" @click="print_dpbo(v.id)">Daftar Pembayaran</a>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                    <div style="text-align: center;" v-else>
                                        <button class="btn btn-sm btn-warning disabled mr-sm-1"><i class="fa fa-wrench"></i> Ubah</button>
                                        <button class="btn btn-sm btn-danger disabled"><i class="fa fa-trash-o"></i> Hapus</button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                <span class="sr-only">Toggle Dropdown</span>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="#" @click="print_sp(v.id)">Surat Perintah</a>
                                                    <a class="dropdown-item" href="#" @click="print_spd(v.id)">Surat Perjalanan Dinas (SPD)</a>
                                                    <a class="dropdown-item" href="#" @click="print_rbpd(v.id)">Rincian Biaya Perjalanan Dinas</a>
                                                    <a class="dropdown-item" href="#" @click="print_dpbo(v.id)">Daftar Pembayaran</a>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right;"><b>Jumlah</b></td>
                                <td style="text-align:right;"><b>Rp.{{ total_anggaran_inspektur | rupiah }}</b></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </transition>
            </div>
        </div>
        <transition>
            <div class="modal" id="delete_inspektur_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body"><p>Anda Akan Menghapus Data Ini, Teruskan?</p></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-flat btn-success" @click="deleteData(inspekturid)">
                                <i class="fa fa-check-circle-o"></i> Ya
                            </button>
                            <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal">
                                <i class="fa fa-times-circle-o"></i> Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>

import service from './../../services.js';
export default {
    data() {
        return {
            isLoading: false,
            options: {},
            alert: {
                error:false,
                empty:false,
                delete:false
            },
            showTable: false,
            inspekturid:'',
            inspekturmodal:false,
            total_anggaran_inspektur : 0
        }
    },
    props: ['dinasbop','dinasbopinspektur', 'route', 'print_action', 'api', 'access'],
    methods: {
        print_sp(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/sp/'+ id +'/inspektur';
        },
        print_spd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/spd/'+ id +'/inspektur';
        },
        print_rbpd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/rbpd/'+ id +'/inspektur';
        },
        print_personil_all(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/all/'+ id +'/inspektur';
        },
        print_dpbo(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/dpbo/'+ id +'/inspektur';
        },
        toggle_modal(id) {
            $('#delete_inspektur_modal').modal('show');
            this.inspekturid = id;
        },
        deleteData(id) {
            service.deleteData(this.api + '/inspektur/' + this.dinasbop.id + '/' + id)
            .then(response => {
                if(response.status === 'OK') {
                    this.alert.delete = true;
                    this.inspekturmodal = false;
                    $('#delete_inspektur_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(function() { this.alert.delete=false; location.reload(); }, 1000);
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                this.inspekturmodal = false;
                $('#delete_inspektur_modal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        }
    },
    created() {
        this.isLoading = true;
        if (this.dinasbopinspektur.length === 0) {
            this.showTable = false;
            this.alert.empty = true;
        } else {
            this.showTable = true;
            for (let index = 0; index < this.dinasbopinspektur.length; index++) {
                this.total_anggaran_inspektur += this.dinasbopinspektur[index]['total'];
            }
            this.alert.empty = false;
        }
    },
    mounted() {
        this.isLoading = false;
    }
};
</script>
