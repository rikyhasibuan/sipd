<template>
    <div style="margin-top:25px;" v-if="emptyData === false">
        <transition name="fade">
            <table class="table table-hover table-striped table-bordered">
                <tbody>
                <tr>
                    <td style="width:15%;"><b>Program</b></td>
                    <td style="width:85%;" >
                        {{ dinasbop.program.nama_program }}
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Kegiatan</b></td>
                    <td style="width:85%;">
                        {{ dinasbop.kegiatan.nama_kegiatan }}
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Belanja</b></td>
                    <td style="width:85%;">
                        {{ dinasbop.belanja.nama_belanja }}
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Dasar Surat Perintah</b></td>
                    <td>
                        <div v-if="dinasboppengumpuldata.dasar !== undefined && dinasboppengumpuldata.dasar.length > 1">
                            <ol style="margin-left:-25px;">
                                <li v-for="(v,k) in dinasboppengumpuldata.dasar" :key="k">
                                    {{ v }}
                                </li>
                            </ol>
                        </div>
                        <div v-else>
                            <span v-if="dinasboppengumpuldata.dasar !== undefined">
                                {{ dinasboppengumpuldata.dasar[0] }}
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Waktu Pemeriksaan</b></td>
                    <td style="width:85%;">{{ dinasboppengumpuldata.dari | moment }} s.d {{ dinasboppengumpuldata.sampai | moment }}</td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Tujuan Pemeriksaan</b></td>
                    <td>
                        <div v-if="dinasboppengumpuldata.untuk !== undefined && dinasboppengumpuldata.untuk.length > 1">
                            <ol style="margin-left:-25px;">
                                <li v-for="(v,k) in dinasboppengumpuldata.untuk" :key="k">
                                    {{ v }}
                                </li>
                            </ol>
                        </div>
                        <div v-else>
                            <span v-if="dinasboppengumpuldata.untuk !== undefined">
                                {{ dinasboppengumpuldata.untuk[0] }}
                            </span>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </transition>

        <div style="margin-top:25px;"></div>

        <div class="row" >
            <div class="col-md-12">
                <div class="pull-left" v-if="emptyData === false">
                    <a v-if="access.update === 1" :href="route + '/pengumpuldata/edit?id='+dinasboppengumpuldata.id+'&dinasbop=' + dinasbop.id" class="btn btn-warning mb-2 mr-2"><i class="fa fa-wrench"></i> Ubah Data Dinas</a>
                    <a v-if="access.write === 1" :href="route + '/timpengumpuldata/create?pengumpuldata='+dinasboppengumpuldata.id+'&dinasbop=' + dinasbop.id" class="btn btn-success mb-2 mr-2"><i class="fa fa-plus"></i> Tambah Tim Pengumpul Data</a>
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
                            <th style="width:15%;text-align:center;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="v in dinasboptimpengumpuldata" :key="v.id">
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
                                <ol style="margin-left:-25px;">
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
                                <br><br><br>
                                {{ v.tim.pengendaliteknis.hari }} hari
                                x
                                Rp.{{ v.tim.pengendaliteknis.biaya | rupiah }} =
                                Rp.{{ v.tim.pengendaliteknis.total | rupiah }}
                                <br><br><br>
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
                                <br>
                                <b>Total : Rp.{{ v.total_anggaran | rupiah }}</b>
                            </td>
                            <td style="text-align: center; vertical-align:middle;">
                                <div style="text-align: center;" v-if="(access.update === 1) & (access.delete === 1)">
                                    <a :href="route + '/timpengumpuldata/edit?pengumpuldata='+ dinasboppengumpuldata.id +'&id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
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
                            <td colspan="2" style="text-align:right;"><b>Jumlah</b></td>
                            <td style="text-align:right;"><b>Rp.{{ total_biaya_tim | rupiah }}</b></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </transition>
                <!-- tampil modal untuk konfirmasi delete -->
                <transition name="fade">
                    <div class="modal" id="pengumpuldatamodal" tabindex="-1" role="dialog">
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
                                    <button type="button" class="btn btn-flat btn-success" @click="deleteData(pengumpuldataid)">
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
        </div>
    </div>
    <div style="margin-top:25px;" v-else>
        <a v-if="access.write == 1" :href="route + '/pengumpuldata/create?dinasbop=' + dinasbop.id" class="btn btn-success mb-2 mr-2"><i class="fa fa-plus"></i> Tambah Data</a>
        <v-alert :alert="alert"></v-alert>
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
                emptyData:false,
                pengumpuldataid:''
            }
        },
        props: ['dinasbop','dinasboppengumpuldata','dinasboptimpengumpuldata', 'route', 'print_action', 'api', 'access'],
        methods: {
            print_sp(id) {
                let new_window = window.open();
                new_window.location = this.api + '/print/sp/'+ id +'/pengumpuldata';
            },
            print_spd(id) {
                let new_window = window.open();
                new_window.location = this.api + '/print/spd/'+ id +'/pengumpuldata';
            },
            print_rbpd(id) {
                let new_window = window.open();
                new_window.location = this.api + '/print/rbpd/'+ id +'/pengumpuldata';
            },
            print_personil(id) {
                let new_window = window.open();
                new_window.location = this.api + '/print/personil/'+ id +'/pengumpuldata';
            },
            print_personil_all(id) {
                let new_window = window.open();
                new_window.location = this.api + '/print/personil/all/'+ id;
            },
            print_dpbo(id) {
                let new_window = window.open();
                new_window.location = this.api + '/print/dpbo/'+ id +'/pengumpuldata';
            },
            toggleModal(id) {
                $("#pengumpuldatamodal").modal('show');
                this.pengumpuldataid = id;
            },
            deleteData(id) {
                service.deleteData(this.api + '/timpengumpuldata?id=' + id)
                    .then(response => {
                        if(response.status === 'ok') {
                            this.alert.delete = true;
                            $('#pengumpuldatamodal').modal('hide');
                            window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                            setTimeout(function() {
                                this.alert.delete=false;
                                location.reload();
                            }, 1000);
                        }
                    }).catch(error => {
                    this.alert.delete = false;
                    this.alert.error = true;
                    $('#pengumpuldatamodal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    console.log(error);
                });
            }
        },
        created() {
            this.isLoading = true;

        },
        mounted() {
            this.isLoading = false;
            if (this.dinasboppengumpuldata.length === 0) {
                this.emptyData = true;
            } else {
                this.emptyData = false;
            }

            if (this.dinasboptimpengumpuldata.length === 0) {
                this.showTable = false;
                this.alert.empty = true;
            } else {
                this.showTable = true;
                this.alert.empty = false;
                let x = 0;
                for (x in this.dinasboptimpengumpuldata) {
                    this.total_biaya_tim += this.dinasboptimpengumpuldata[x].total_anggaran;
                }
            }
        }
    };
</script>
