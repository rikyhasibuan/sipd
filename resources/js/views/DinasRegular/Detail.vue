<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <transition name="fade">
                        <table class="table table-hover table-striped table-bordered">
                            <tbody>
                            <tr>
                                <td style="width:15%;"><b>Program</b></td>
                                <td>{{ dinasregular.program.nama_program }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Kegiatan</b></td>
                                <td>{{ dinasregular.kegiatan.nama_kegiatan }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Belanja</b></td>
                                <td >{{ dinasregular.belanja.nama_belanja }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Anggaran Tersedia</b></td>
                                <td>Rp.{{ anggaran_tersedia | rupiah }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Tempat Tujuan</b></td>
                                <td>{{ dinasregular.auditan }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Nomor Surat Perintah</b></td>
                                <td>{{ dinasregular.nomor_sp }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Tanggal Surat Perintah</b></td>
                                <td>{{ dinasregular.tgl_sp | moment }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Dasar Surat Perintah</b></td>
                                <td>
                                    <div v-if="dinasregular.dasar.length > 1">
                                        <ol style="margin-left:-25px;">
                                            <li v-for="v in dinasregular.dasar" :key="v">
                                                {{ v }}
                                            </li>
                                        </ol>
                                    </div>
                                    <div v-else>
                                        {{ dinasregular.dasar[0] }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Waktu</b></td>
                                <td>{{ dinasregular.dari | moment }} s.d {{ dinasregular.sampai | moment }}</td>
                            </tr>
                            <tr>
                                <td style="width:15%;"><b>Tujuan</b></td>
                                <td>
                                    <div v-if="dinasregular.untuk.length > 1">
                                        <ol style="margin-left:-25px;">
                                            <li v-for="v in dinasregular.untuk" :key="v">
                                                {{ v }}
                                            </li>
                                        </ol>
                                    </div>
                                    <div v-else>
                                        {{ dinasregular.untuk[0] }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:15%;">
                                    <b>Status Approval</b>
                                </td>
                                <td>
                                    <span v-if="dinasregularapproval.kassubag.approval === 1" class="badge badge-success" style="padding:0.75em 0.75em !important;">KASSUBAG SUDAH MENYETUJUI</span>
                                    <span v-if="dinasregularapproval.sekretaris.approval === 1" class="badge badge-success" style="padding:0.75em 0.75em !important;">SEKRETARIS SUDAH MENYETUJUI</span>
                                    <span v-if="dinasregularapproval.inspektur.approval === 1" class="badge badge-success" style="padding:0.75em 0.75em !important;">INSPEKTUR SUDAH MENYETUJUI</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </transition>

                    <div style="margin-top:25px;"></div>

                    <span v-if="access.approval === 1">
                        <a v-if="(approval_type === 'kassubag' || approval_type === 'administrator') && (dinasregularapproval.kassubag.approval === 0)" class="btn btn-warning mb-2 mr-2" href="#" @click="toggleRevisiModal('kassubag')">
                            <i class="fa fa-edit"></i> Form Revisi Kassubag
                        </a>
                        <a v-if="(approval_type === 'kassubag' || approval_type === 'administrator') && (dinasregularapproval.kassubag.approval === 0)" class="btn btn-success mb-2 mr-2" href="#" @click="toggleApprovalModal('kassubag')">
                            <i class="fa fa-check"></i> Approval Kassubag
                        </a>
                        <a v-if="(approval_type === 'sekretaris' || approval_type === 'administrator') && (dinasregularapproval.sekretaris.approval === 0)" class="btn btn-warning mb-2 mr-2" href="#" @click="toggleRevisiModal('sekretaris')">
                            <i class="fa fa-edit"></i> Form Revisi Sekretaris
                        </a>
                        <a v-if="(approval_type === 'sekretaris' || approval_type === 'administrator') && (dinasregularapproval.sekretaris.approval === 0)" class="btn btn-success mb-2 mr-2" href="#" @click="toggleApprovalModal('sekretaris')">
                            <i class="fa fa-check"></i> Approval Sekretaris
                        </a>
                        <a v-if="(approval_type === 'inspektur' || approval_type === 'administrator') && (dinasregularapproval.inspektur.approval === 0)" class="btn btn-warning mb-2 mr-2" href="#" @click="toggleRevisiModal('inspektur')">
                            <i class="fa fa-edit"></i> Form Revisi Inspektur
                        </a>
                        <a v-if="(approval_type === 'inspektur' || approval_type === 'administrator') && (dinasregularapproval.inspektur.approval === 0)" class="btn btn-success mb-2 mr-2" href="#" @click="toggleApprovalModal('inspektur')">
                            <i class="fa fa-check"></i> Approval Inspektur
                        </a>
                    </span>

                    <div style="margin-top:15px;"></div>

                    <h4>Daftar Personil</h4>
                    <hr>

                    <transition name="fade">
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width:12%;text-align:center;vertical-align:middle;">Nama</th>
                                <th rowspan="2" style="width:5%;text-align:center;vertical-align:middle;">Pangkat/Golongan</th>
                                <th rowspan="2" style="width:10%;text-align:center;vertical-align:middle;">Jabatan</th>
                                <th rowspan="2" style="width:11%;text-align:center;vertical-align:middle;">Harian</th>
                                <th rowspan="2" style="width:11%;text-align:center;vertical-align:middle;">Akomodasi</th>
                                <th colspan="3" style="width:11%;text-align:center;vertical-align:middle;">Transportasi</th>
                            </tr>
                            <tr>
                                <th style="width:3%;text-align:center;vertical-align:middle;">BBM</th>
                                <th style="width:3%;text-align:center;vertical-align:middle;">Sewa Kendaraan</th>
                                <th style="width:3%;text-align:center;vertical-align:middle;">Tiket</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(v,k) in dinasregular.tim" :value="k" :key="k">
                                <td style="vertical-align:middle;">{{ v.nama }}</td>
                                <td style="text-align:center;vertical-align:middle;">{{ v.pangkat }} {{ v.golongan}}</td>
                                <td style="text-align:center;vertical-align:middle;">{{ v.jabatan }}</td>
                                <td style="text-align:right;vertical-align:middle;">
                                    {{ v.hari }} hari x {{ v.biaya_harian | rupiah }} = {{ v.total_harian | rupiah }}
                                </td>
                                <td style="text-align:right;vertical-align:middle;">
                                    {{ v.inap }} hari x {{ v.biaya_akomodasi | rupiah }} = {{ v.total_akomodasi | rupiah }}
                                </td>
                                <td style="vertical-align:middle;" v-if="k === 0" :rowspan="dinasregular.tim.length">
                                    <div v-if="(dinasregular.total_transportasi.total > 0) && (dinasregular.total_transportasi.jenis === 'BBM')" >
                                        <div style="text-align: center;">{{ dinasregular.total_transportasi.total | rupiah }}</div>
                                    </div>
                                </td>
                                <td style="vertical-align:middle;" v-if="k === 0" :rowspan="dinasregular.tim.length">
                                    <div v-if="(dinasregular.total_transportasi.total > 0) && (dinasregular.total_transportasi.jenis === 'Sewa Kendaraan')" >
                                        <div style="text-align: center;">{{ dinasregular.total_transportasi.total | rupiah }}</div>
                                    </div>
                                </td>
                                <td v-if="k === 0" :rowspan="dinasregular.tim.length" style="vertical-align:middle;">
                                    <div v-if="(dinasregular.total_transportasi.total > 0) && (dinasregular.total_transportasi.jenis === 'Tiket')" >
                                        <div style="text-align: center;">{{ dinasregular.total_transportasi.total | rupiah }}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right;"></td>
                                <td style="text-align:right;">Rp.{{ dinasregular.total_harian | rupiah }}</td>
                                <td style="text-align:right;">Rp.{{ dinasregular.total_akomodasi | rupiah }}</td>
                                <td style="text-align:right;" v-if="(dinasregular.total_transportasi.total > 0) && (dinasregular.total_transportasi.jenis === 'BBM')" >Rp.{{ dinasregular.total_transportasi.total | rupiah }}</td>
                                <td v-else></td>
                                <td style="text-align:right;" v-if="(dinasregular.total_transportasi.total > 0) && (dinasregular.total_transportasi.jenis === 'Sewa Kendaraan')" >Rp.{{ dinasregular.total_transportasi.total | rupiah }}</td>
                                <td v-else></td>
                                <td style="text-align:right;" v-if="(dinasregular.total_transportasi.total > 0) && (dinasregular.total_transportasi.jenis === 'Tiket')" >Rp.{{ dinasregular.total_transportasi.total | rupiah }}</td>
                                <td v-else></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align:right;"><strong>Total</strong></td>
                                <td colspan="3">
                                    <b>Rp.{{ total_biaya | rupiah }}</b>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </transition>

                    <!-- Transportasi Modal -->
                    <transition name="fade" id="transportasi">
                        <div class="modal" id="transportasimodal" tabindex="-1" role="dialog" v-if="showTransportasiModal" @close="showTransportasiModal = false">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Transportasi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <div class="row">
                                                <div class="form-group col-md-12 col-xs-12">
                                                    <label>Akomodasi  *</label>
                                                    <select v-model="transportasi.durasi" class="form-control">
                                                        <option value="">Pilih Jumlah Hari</option>
                                                        <option v-for="(v,k) in this.durasi_inap" :value="v" :key="k">{{ v }} Hari</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-12 col-xs-12">
                                                    <label>Jenis Transportasi *</label>
                                                    <select v-model="transportasi.jenis" class="form-control" @change="onChangeJenisTransportasi" required="required">
                                                        <option value="">Pilih Jenis Transportasi</option>
                                                        <option v-for="(v,k) in this.jenis_transportasi" :value="v" :key="k">{{ v }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" v-if="show_liter === true">
                                                <div class="form-group col-md-12 col-xs-12">
                                                    <label>Liter *</label>
                                                    <select v-model="transportasi.liter" class="form-control" @change="onChangeLiter($event)">
                                                        <option value="">Pilih Jumlah Liter</option>
                                                        <option v-for="(v,k) in this.takaran_liter" :value="v" :key="k">{{ v }} Liter</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-12 col-xs-12">
                                                    <label>Total Transportasi *</label>
                                                    <input type="text" v-model="transportasi.total" class="form-control" required="required">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <button type="button" class="btn btn-flat btn-success" @click.prevent="simpanTransportasi(id)"><i class="fa fa-check"></i> Simpan</button>
                                                    <button type="button" class="btn btn-flat btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>

                    <hr>
                    <transition name="fade"><v-revision-log :revision=dinasregularapproval></v-revision-log></transition>
                    <transition name="fade"><v-revision :element="'reguler_revision_modal'" :role="approval_role" @revision="createRevision"></v-revision></transition>
                    <transition name="fade"><v-approval :element="'reguler_approval_modal'" :role="approval_role" @approve="createApproval"></v-approval></transition>

                    <a href="#" v-if="access.update == 1 && dinasregularapproval.lock == 0" @click="transportasiModal(dinasregular.id)" data-toggle="modal" data-target="#transportasimodal" class="btn btn-warning mb-2 mr-2"><i class="fa fa-car"></i> Transportasi & Akomodasi</a>
                    <div class="btn-group mb-2 mr-2" v-if="dinasregularapproval.lock == 1">
                        <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#" @click="print_sp(dinasregular.id)">Surat Perintah</a>
                                <a class="dropdown-item" href="#" @click="print_spd(dinasregular.id)">Surat Perjalanan Dinas</a>
                                <a class="dropdown-item" href="#" @click="print_rbpd(dinasregular.id)">Rincian Biaya Perjalanan Dinas</a>
                                <a class="dropdown-item" href="#" @click="print_dpbo(dinasregular.id)">Daftar Pembayaran</a>
                            </div>
                        </button>
                    </div>

                    <a :href="route" class="btn btn-danger mb-2 mr-2"><i class="fa fa-arrow-left"></i> Kembali</a>

                </div>
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
            transportasi : {
                total:0,
                liter:'',
                jenis:'',
                durasi:'',
            },
            total_biaya:0,
            anggaran_tersedia: 0,
            durasi_inap:[],
            showTable: false,
            show_liter: false,
            id:'',
            showTransportasiModal: false,
            counter:0,
            approval_type: '',
            approval_role:''
        }
    },
    props: ['dinasregular', 'dinasregularapproval', 'jenis_transportasi', 'takaran_liter', 'route', 'api', 'access'],
    methods: {
        print_sp(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/sp/'+ id;
        },
        print_spd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/spd/'+ id;
        },
        print_rbpd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/rbpd/'+ id;
        },
        print_dpbo(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/dpbo/'+ id;
        },
        onChangeLiter(evt) {
            const jumlah_liter = evt.target.value;
            service.postData('../api/ajax/totalhargabbm/', {'jumlah_liter':jumlah_liter})
            .then(response => {
                this.transportasi.total = response.total_bbm;
            }).catch(error => {
                console.log(error);
            });
        },
        onChangeJenisTransportasi(evt) {
            const jenistransportasi = evt.target.value;
            if (jenistransportasi === 'BBM') {
                this.show_liter = true;
            } else {
                this.show_liter = false;
                this.transportasi.liter = '';
                this.transportasi.total = 0;
            }
        },
        transportasiModal(id) {
            this.showTransportasiModal = true;
            this.id = id;
        },
        simpanTransportasi(evt) {
            service.putData(this.api + '/transportasi?id=' + this.dinasregular.id, this.transportasi)
                .then(result => {
                    $('#transportasimodal').modal('hide');
                    alert('PROSES SIMPAN DATA BERHASIL!');
                    location.reload();
                }).catch(error => {
                    $('#transportasimodal').modal('hide');
                    alert('TERJADI KESALAHAN! SILAHKAN ULANGI KEMBALI!.')
                    console.log(error);
                });
        },
        getAnggaranTersedia() {
            service.postData('../api/ajax/sisa_anggaran', { 'tahun': this.dinasregular.created_at, 'kegiatan': this.dinasregular.kegiatan_id })
                .then(result => {
                    this.anggaran_tersedia = parseInt(result.sisa_anggaran);
                }).catch(error => {
                    console.log(error);
                });
        },
        toggleRevisiModal(role) {
            this.approval_role = role;
            $("#reguler_revision_modal").modal('show');
        },
        toggleApprovalModal(role) {
            this.approval_role = role;
            $("#reguler_approval_modal").modal('show');
        },
        createRevision(callback) {
            service.putData(this.api + '/approval?act=revision&type='+callback.role+'&id=' + this.dinasregular.id, { catatan: callback.catatan})
                .then(response => {
                    if(response.status === 'ok') {
                        $('#reguler_revision_modal').modal('hide');
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                        alert('CATATAN REVISI BERHASIL DIBUAT');
                        location.reload();
                    }
                }).catch(error => {
                    this.alert.error = true;
                    $('#reguler_revision_modal').modal('hide');
                    alert('TERJADI KESALAHAN PADA SISTEM!');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    console.log(error);
                });
        },
        createApproval(role) {
            service.putData(this.api + '/approval?act=approve&type='+role+'&id=' + this.dinasregular.id)
            .then(response => {
                if(response.status === 'ok') {
                    $('#reguler_approval_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    alert('PROSES APPROVAL BERHASIL');
                    location.reload();
                }
            }).catch(error => {
                $('#reguler_approval_modal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                alert('TERJADI KESALAHAN PADA SISTEM!');
                console.log(error);
            });
        }
    },
    created() {
        this.isLoading = true;
        this.getAnggaranTersedia();
    },
    mounted() {
        this.isLoading = false;
        this.total_biaya = parseInt(this.dinasregular.total_harian) + parseInt(this.dinasregular.total_akomodasi) + parseInt(this.dinasregular.total_transportasi.total);

        const date_diff = this.$options.filters.short_difference(this.dinasregular.dari, this.dinasregular.sampai);

        for (let i = 1; i <= date_diff; i++) {
            this.durasi_inap.push(i);
        }

        if (this.dinasregular.total_transportasi !== null) {
            this.transportasi.liter = this.dinasregular.total_transportasi.liter;
            this.transportasi.jenis = this.dinasregular.total_transportasi.jenis;
            this.transportasi.total = this.dinasregular.total_transportasi.total;
            this.transportasi.durasi = this.dinasregular.lama_inap;
        }

        let level = this.$cookies.get('level');
        if (level === '1') {
            this.approval_type = 'administrator';
        } else if (level == '3') {
            if (this.$cookies.get('jabatan') == 'Inspektur') {
                this.approval_type = 'inspektur';
            } else if (this.$cookies.get('jabatan') == 'Sekretaris') {
                this.approval_type = 'sekretaris';
            } else if (this.$cookies.get('jabatan') == 'Kepala Sub Bagian Kepegawaian dan Umum') {
                this.approval_type = 'kassubag';
            } else if (this.$cookies.get('jabatan') == 'Kepala Sub Bagian Keuangan dan Aset') {
                this.approval_type = 'kassubag';
            } else if (this.$cookies.get('jabatan') == 'Kepala Sub Bagian Perencanaan dan Pelaporan') {
                this.approval_type = 'kassubag';
            }
        } else if (level == '2') {
            this.approval_type = 'operator';
        }
    }
};
</script>
