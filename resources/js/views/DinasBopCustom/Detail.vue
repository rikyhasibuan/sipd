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
                    <td>
                        <div v-if="dinasbop.dasar.length > 1">
                            <ol style="margin-left:-25px;">
                                <li v-for="(v,k) in dinasbop.dasar" :key="k">
                                    {{ v }}
                                </li>
                            </ol>
                        </div>
                        <div v-else>
                            {{ dinasbop.dasar[0] }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Waktu Pemeriksaan</b></td>
                    <td style="width:85%;">{{ dinasbop.dari | moment }} s.d {{ dinasbop.sampai | moment }}</td>
                </tr>
                <tr>
                    <td style="width:15%;"><b>Tujuan Pemeriksaan</b></td>
                    <td>
                        <div v-if="dinasbop.untuk.length > 1">
                            <ol style="margin-left:-25px;">
                                <li v-for="(v,k) in dinasbop.untuk" :key="k">
                                    {{ v }}
                                </li>
                            </ol>
                        </div>
                        <div v-else>
                            {{ dinasbop.untuk[0] }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width:15%;">
                        <b>Status Approval</b>
                    </td>
                    <td>
                        <span v-if="approval_tab.kassubag.approval === 1" class="badge badge-success" style="padding:0.75em 0.75em !important;">KASSUBAG SUDAH MENYETUJUI</span>
                        <span v-if="approval_tab.sekretaris.approval === 1" class="badge badge-success" style="padding:0.75em 0.75em !important;">SEKRETARIS SUDAH MENYETUJUI</span>
                        <span v-if="approval_tab.inspektur.approval === 1" class="badge badge-success" style="padding:0.75em 0.75em !important;">INSPEKTUR SUDAH MENYETUJUI</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </transition>
    <div style="margin-top:25px;"></div>
    <div class="row">
        <div class="col-md-12">
            <hr>
            <div class="pull-left">
                <a v-if="(approval_tab.lock === 0 && access.write === 1) && (dinasbop.status === 0 && access.write === 1)" :href="route + '/custom/create?dinasbop=' + dinasbop.id" class="btn btn-success mb-2 mr-2"><i class="fa fa-plus"></i> Tambah Tim</a>
                <!-- <span v-if="dinasbopcustom.length > 0">
                    <a v-if="approval_tab.lock === 1 || dinasbop.status === 1 && dinasbopcustom.length !== 0" class="btn btn-default mb-2 mr-2" href="#" @click="print_personil_all(dinasbop.id)"><i class="fa fa-users"></i> Cetak Daftar Personil</a>
                </span> -->

                <span v-if="dinasbopcustom.length !== 0 && access.approval === 1 && dinasbop.status === 0">
                    <a v-if="(approval_type === 'kassubag' || approval_type === 'administrator') && (approval_tab.kassubag.approval === 0)" class="btn btn-warning mb-2 mr-2" href="#" @click="toggleRevisiModal('kassubag')">
                        <i class="fa fa-edit"></i> Form Revisi Kassubag
                    </a>
                    <a v-if="(approval_type === 'kassubag' || approval_type === 'administrator') && (approval_tab.kassubag.approval === 0)" class="btn btn-success mb-2 mr-2" href="#" @click="toggleApprovalModal('kassubag')">
                        <i class="fa fa-check"></i> Approval Kassubag
                    </a>
                    <a v-if="(approval_type === 'sekretaris' || approval_type === 'administrator') && (approval_tab.sekretaris.approval === 0)" class="btn btn-warning mb-2 mr-2" href="#" @click="toggleRevisiModal('sekretaris')">
                        <i class="fa fa-edit"></i> Form Revisi Sekretaris
                    </a>
                    <a v-if="(approval_type === 'sekretaris' || approval_type === 'administrator') && (approval_tab.sekretaris.approval === 0)" class="btn btn-success mb-2 mr-2" href="#" @click="toggleApprovalModal('sekretaris')">
                        <i class="fa fa-check"></i> Approval Sekretaris
                    </a>
                    <a v-if="(approval_type === 'inspektur' || approval_type === 'administrator') && (approval_tab.inspektur.approval === 0)" class="btn btn-warning mb-2 mr-2" href="#" @click="toggleRevisiModal('inspektur')">
                        <i class="fa fa-edit"></i> Form Revisi Inspektur
                    </a>
                    <a v-if="(approval_type === 'inspektur' || approval_type === 'administrator') && (approval_tab.inspektur.approval === 0)" class="btn btn-success mb-2 mr-2" href="#" @click="toggleApprovalModal('inspektur')">
                        <i class="fa fa-check"></i> Approval Inspektur
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <v-alert :alert="alert"></v-alert>
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
                        <tr v-for="v in dinasbopcustom" :key="v.id">
                            <td style="text-align: center;vertical-align:middle;">
                                {{ v.auditan }}
                                <br>
                                Nomor : <b>{{ v.nomor_sp }}</b>
                                <br>
                                Tanggal : {{ v.tgl_sp | moment }}
                            </td>
                            <td>
                                <b>Penanggungjawab</b>
                                <br>
                                {{ v.tim.penanggungjawab.nama }}
                                <br><br>
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
                                {{ v.tim.penanggungjawab.hari }} hari
                                x
                                Rp.{{ v.tim.penanggungjawab.biaya | rupiah }} =
                                Rp.{{ v.tim.penanggungjawab.total | rupiah }}
                                <br><br><br>
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
                                <div>
                                    <a target="__blank" :href="'..'+ v.lampiran" style="font-size: 20px;">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            </td>
                            <td style="text-align: center; vertical-align:middle;">
                                <div style="text-align: center;">
                                    <a v-if="(approval_tab.lock === 0 && access.update === 1) && (dinasbop.status === 0 && access.update === 1)" :href="route + '/custom/edit?dinasbop='+ dinasbop.id +'&id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
                                        <i class="fa fa-wrench"></i> Ubah
                                    </a>
                                    <button v-else class="btn btn-sm btn-warning disabled mr-sm-1"><i class="fa fa-wrench"></i> Ubah</button>
                                    <a v-if="(approval_tab.lock === 0 && access.delete === 1) && (dinasbop.status === 0 && access.delete === 1)" href="#" @click="toggleModal(v.id)"
                                        class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash-o"></i> Hapus
                                    </a>
                                    <button v-else class="btn btn-sm btn-danger disabled"><i class="fa fa-trash-o"></i> Hapus</button>
                                    <div class="btn-group" v-if="approval_tab.lock === 1 || dinasbop.status === 1">
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
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </transition>
            <transition name="fade"><v-delete :element="'custom_delete_modal'" :id="id" @delete="deleteData"></v-delete></transition>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12" v-if="dinasbopcustom.length !== 0">
            <hr>
            <transition name="fade"><v-revision-log :element=element :revision=approval_tab></v-revision-log></transition>
            <transition name="fade"><v-revision :role="approval_role" :element="'custom_revision_modal'" @revision="createRevision"></v-revision></transition>
            <transition name="fade"><v-approval :role="approval_role" :element="'custom_approval_modal'" @approve="createApproval"></v-approval></transition>
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
            id:'',
            element: {
                kassubag_href: '#customrevlogkassubag',
                kassubag_id: 'customrevlogkassubag',
                sekretaris_href: '#customrevlogsekretaris',
                sekretaris_id: 'customrevlogsekretaris',
                inspektur_href: '#customrevloginspektur',
                inspektur_id: 'customrevloginspektur'
            },
            approval_tab: {
                kassubag:{
                    catatan:[],
                    approval:0
                },
                sekretaris:{
                    catatan:[],
                    approval:0
                },
                inspektur:{
                    catatan:[],
                    approval:0
                },
                lock:0
            },
            approval_role:'',
            usernip:''
        }
    },
    props: ['dinasbop', 'dinasbopapproval', 'dinasbopcustom', 'route', 'print_action', 'api', 'access', 'approval_type'],
    methods: {
        print_sp(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/sp/'+ id +'/custom';
        },
        print_spd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/spd/'+ id +'/custom';
        },
        print_rbpd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/rbpd/'+ id +'/custom';
        },
        print_personil(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/'+ id +'/custom';
        },
        print_personil_all(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/all/'+ id;
        },
        print_dpbo(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/dpbo/'+ id +'/custom';
        },
        toggleModal(id) {
            $("#custom_delete_modal").modal('show');
            this.id = id;
        },
        toggleRevisiModal(role) {
            this.approval_role = role;
            $("#custom_revision_modal").modal('show');
        },
        toggleApprovalModal(role) {
            this.approval_role = role;
            $("#custom_approval_modal").modal('show');
        },
        deleteData(id) {
            service.deleteData(this.api + '/custom?nip='+this.usernip+'&dinasbop='+this.dinasbop.id+'&id='+id)
            .then(response => {
                if(response.status === 'ok') {
                    this.alert.delete = true;
                    $('#custom_delete_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(function() {
                        this.alert.delete=false;
                        location.reload();
                    }, 1000);
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                $('#custom_delete_modal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        },
        createRevision(callback) {
            service.putData(this.api + '/approval?nip='+this.usernip+'&act=revision&type='+callback.role+'&tab=custom&id='+this.dinasbop.id, {catatan: callback.catatan})
            .then(response => {
                if(response.status === 'ok') {
                    $('#custom_revision_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    alert('CATATAN REVISI BERHASIL DIBUAT');
                    location.reload();
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                $('#custom_revision_modal').modal('hide');
                alert('TERJADI KESALAHAN PADA SISTEM!');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        },
        createApproval(role) {
            service.putData(this.api + '/approval?nip='+this.usernip+'&act=approve&type='+role+'&tab=custom&id='+this.dinasbop.id)
            .then(response => {
                if(response.status === 'ok') {
                    $('#custom_approval_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    alert('PROSES APPROVAL BERHASIL');
                    location.reload();
                }
            }).catch(error => {
                $('#custom_approval_modal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                alert('TERJADI KESALAHAN PADA SISTEM!');
                console.log(error);
            });
        }
    },
    created() {
        this.isLoading = true;
        if (this.dinasbopcustom.length === 0) {
            this.showTable = false;
            this.alert.empty = true;
        } else {
            this.showTable = true;
            this.alert.empty = false;
            let x = 0;
            for (x in this.dinasbopcustom) {
                this.total_biaya_tim += this.dinasbopcustom[x].total_anggaran;
            }
        }
    },
    mounted() {
        this.isLoading = false;
        this.approval_tab = this.dinasbopapproval.find(dinasbopapproval => dinasbopapproval.tab === 'custom');
        this.usernip = this.$cookies.get('nip');
    }
};
</script>
