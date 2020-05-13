<template>
    <div style="margin-top:25px;">
        <transition name="fade">
            <table class="table table-hover table-striped table-bordered" v-if="showTable == true">
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
                    <tr>
                        <td style="width:15%;"><b>Dasar Surat Perintah</b></td>
                        <td style="width:85%;">
                            <ul style="margin-left:-25px;">
                                <li v-for="v in dinasbopsupervisi.dasar" :value="v" :key="v">
                                    {{ v }}
                                </li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><b>Waktu Pemeriksaan</b></td>
                        <td style="width:85%;">{{ dinasbopsupervisi.dari | moment }} s.d {{ dinasbopsupervisi.sampai | moment }}</td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><b>Tujuan Pemeriksaan</b></td>
                        <td style="width:85%;">
                            <ul style="margin-left:-25px;">
                                <li v-for="v in dinasbopsupervisi.tujuan" :value="v" :key="v">
                                    {{ v }}
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </transition>
        <div style="margin-top:25px;"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">
                    <span v-if="dinasbopsupervisi.length === 0">
                    <a :href="route + '/supervisi/create?dinasbop=' + dinasbop.id" class="btn btn-success mb-2 mr-2"><i class="fa fa-plus"></i> Tambah Tim Reviu & Monitoring</a>
                    </span>
                    <span v-else>
                        <a :href="route + '/supervisi/edit?id='+ dinasbopsupervisi.id +'&dinasbop=' + dinasbop.id" class="btn btn-warning mb-2 mr-2"><i class="fa fa-wrench"></i> Ubah Tim Reviu & Monitoring</a>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default mb-2"><i class="fa fa-print"></i> Print</button>
                            <button type="button" class="btn btn-default mb-2 dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="#" @click="print_sp(v.id)">Surat Perintah</a>
                                    <a class="dropdown-item" href="#" @click="print_spd(v.id)">Surat Perjalanan Dinas (SPD)</a>
                                    <a class="dropdown-item" href="#" @click="print_rbpd(v.id)">Rincian Biaya Perjalanan Dinas</a>
                                    <a class="dropdown-item" href="#" @click="print_dpbo(v.id)">Daftar Pembayaran</a>
                                </div>
                            </button>
                        </div>
                    </span>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <v-alert :alert="alert"></v-alert>
                <!-- tampil tim -->
                <transition name="fade">
                    <table class="table table-hover table-striped table-bordered" v-if="showTable == true">
                        <thead>
                            <tr>
                                <th style="width:5%;text-align:center;">NIP</th>
                                <th style="width:12%;text-align:center;">Nama</th>
                                <th style="width:12%;text-align:center;">Jabatan</th>
                                <th style="width:5%;text-align:center;">Peran</th>
                                <th style="width:12%;text-align:center;">Rincian Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ dinasbopsupervisi.tim.ketuatim.nip }}</td>
                                <td>{{ dinasbopsupervisi.tim.ketuatim.nama }}</td>
                                <td>{{ dinasbopsupervisi.tim.ketuatim.jabatan }}</td>
                                <td style="text-align:center;">Ketua Tim</td>
                                <td style="text-align:right;">
                                    {{
                                        dinasbopsupervisi.tim.ketuatim.hari }} hari x
                                    Rp.{{ dinasbopsupervisi.tim.ketuatim.biaya | rupiah }} =
                                    Rp.{{ dinasbopsupervisi.tim.ketuatim.total | rupiah }}
                                </td>
                            </tr>
                            <tr v-for="v in dinasbopsupervisi.tim.anggota" :key="v.nip">
                                <td>{{ v.nip }}</td>
                                <td>{{ v.nama }}</td>
                                <td>{{ v.jabatan }}</td>
                                <td style="text-align:center;">Anggota</td>
                                <td style="text-align:right;">
                                    {{ v.hari }} hari x Rp.{{ v.biaya | rupiah }} = Rp.{{ v.total | rupiah }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:right;"><b>Jumlah</b></td>
                                <td style="text-align:right;"><b>Rp.{{ dinasbopsupervisi.total_anggaran | rupiah }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </transition>
            </div>
        </div>
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
            total_biaya_tim:0,
            showTable: false,
            id:''
        }
    },
    props: ['dinasbop', 'dinasbopsupervisi', 'route', 'print_action', 'api'],
    methods: {
        print_sp(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/sp/'+ id +'/supervisi';
        },
        print_spd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/spd/'+ id +'/supervisi';
        },
        print_rbpd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/rbpd/'+ id +'/supervisi';
        },
        print_personil(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/'+ id +'/supervisi';
        },
        print_personil_all(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/all/'+ id;
        },
        print_dpbo(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/dpbo/'+ id +'/supervisi';
        }
    },
    created() {
        this.isLoading = true;
        if (this.dinasbopsupervisi.length === 0) {
            this.showTable = false;
            this.alert.empty = true;
        } else {
            this.showTable = true;
            this.alert.empty = false;
            let x = 0;
            for (x in this.dinasbopsupervisi) {
                this.total_biaya_tim += this.dinasbopsupervisi[x].total_anggaran;
            }
        }
    },
    mounted() {
        this.isLoading = false;
    }
};
</script>
