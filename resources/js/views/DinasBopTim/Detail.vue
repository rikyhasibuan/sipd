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
                <tr>
                    <td style="width:15%;"><b>Dasar Surat Perintah</b></td>
                    <td style="width:85%;">
                        <ul>
                            <li v-for="v in dinasbop.dasar" :value="v" :key="v">
                                {{ v }}
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Waktu Pemeriksaan</b></td>
                    <td style="width:85%;">{{ dinasbop.dari | moment }} s.d {{ dinasbop.sampai | moment }}</td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Tujuan Pemeriksaan</b></td>
                    <td style="width:85%;">
                        <ul>
                            <li v-for="v in dinasbop.untuk" :value="v" :key="v">
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
                <a :href="route + '/tim/create?dinasbop=' + dinasbop.id" class="btn btn-success mb-2"><i class="fa fa-plus"></i> Tambah Tim</a>
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
                            <th style="width:15%;text-align:center;">Auditan</th>
                            <th style="width:15%;text-align:center;">Personil</th>
                            <th style="width:15%;text-align:center;">Rincian Biaya</th>
                            <th style="width:1%;text-align:center;">Lampiran</th>
                            <th style="width:15%;text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="v in dinasboptim" :key="v.id">
                            <td style="text-align: center;vertical-align:middle;">
                                {{ v.auditan }}
                                <br>
                                Nomor : <b>{{ v.nomor_sp }}</b>
                                <br>
                                Tanggal : {{ v.tgl_sp | moment }}
                            </td>
                            <td>
                                <b>Wakil Penanggungjawab</b>
                                <br>
                                {{ v.tim.wakilpenanggungjawab.nama }}
                                <br><br>
                                <b>Pengendali Teknis</b>
                                <br>
                                {{ v.tim.pengendaliteknis.nama }}
                                <br><br>
                                <b>Ketua Tim</b>
                                <br>
                                {{ v.tim.ketuatim.nama }}
                                <br><br>
                                <b>Anggota Tim</b>
                                <ol>
                                    <li v-for="y in v.tim.anggota" :key="y.nip">{{ y.nama }}</li>
                                </ol> 
                            </td>
                            <td>
                                <b></b>
                                <br>
                                {{ v.tim.wakilpenanggungjawab.hari }} hari 
                                x 
                                Rp.{{ v.tim.wakilpenanggungjawab.biaya | rupiah }} = 
                                Rp.{{ v.tim.wakilpenanggungjawab.total | rupiah }}
                                <br><br>
                                <br>
                                {{ v.tim.pengendaliteknis.hari }} hari 
                                x 
                                Rp.{{ v.tim.pengendaliteknis.biaya | rupiah }} = 
                                Rp.{{ v.tim.pengendaliteknis.total | rupiah }}
                                <br><br>
                                <br>
                                {{ v.tim.ketuatim.hari }} hari 
                                x 
                                Rp.{{ v.tim.ketuatim.biaya | rupiah }} = 
                                Rp.{{ v.tim.ketuatim.total | rupiah }}
                                <br><br><br>
                                <ul style="list-style:none;margin-left: -40px;">
                                    <li v-for="z in v.tim.anggota" :key="z.nip">
                                        {{ z.hari }} hari 
                                        x 
                                        Rp.{{ z.biaya | rupiah }} = 
                                        Rp.{{ z.total | rupiah }}
                                    </li>
                                </ul>
                            </td>
                            <td style="text-align: center; vertical-align:middle;">
                                <div>
                                    <a target="__blank" :href="'..'+ v.lampiran" style="font-size: 20px;">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            </td>
                            <td style="text-align: center; vertical-align:middle;">
                                <div>
                                    <a :href="route + '/tim/edit?dinasbop='+ dinasbop.id +'&id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
                                        <i class="fa fa-wrench"></i> Ubah
                                    </a>
                                    <a href="#" @click="toggleModal(v.id)"
                                        class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash-o"></i> Hapus
                                    </a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            <div class="dropdown-menu" role="menu">
                                                <a class="dropdown-item" href="#" @click="print_personil(v.id)">Daftar Personil</a>
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
                            <td colspan="2" style="text-align:right;"><b>Jumlah</b></td>
                            <td style="text-align:right;"><b>Rp.{{ dinasbop.total_anggaran | rupiah }}</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </transition>
            <!-- tampil modal untuk konfirmasi delete -->
            <transition name="fade"><v-modal :id="id" @delete="deleteData"></v-modal></transition>
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
            showTable: false,
            id:''
        }
    },
    props: ['dinasbop', 'dinasboptim', 'route', 'print_action', 'api'],
    methods: {
        print_sp(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/sp/'+ id +'/tim';
        },
        print_spd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/spd/'+ id +'/tim';
        },
        print_rbpd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/rbpd/'+ id +'/tim';
        },
        print_personil(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/'+ id +'/tim';
        },
        print_personil_all(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/all/'+ id +'/tim';
        },
        print_dpbo(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/dpbo/'+ id +'/tim';
        },
        toggleModal(id) {
            $("#deletemodal").modal('show');
            this.id = id;
        },
        deleteData(id) {
            service.deleteData(this.api + '/tim/' + this.dinasbop.id + '/' + id)
            .then(response => {
                if(response.status === 'OK') {
                    this.alert.delete = true;
                    $('#deletemodal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(function() { 
                        this.alert.delete=false; 
                        location.reload();
                    }, 1000);
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                $('#deletemodal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        }
    },
    created() {
        this.isLoading = true;
        if (this.dinasboptim.length === 0) {
            this.showTable = false;
            this.alert.empty = true;
        } else {
            this.showTable = true;
            this.alert.empty = false;
        }
    },
    mounted() {
        this.isLoading = false;
    }
};
</script>