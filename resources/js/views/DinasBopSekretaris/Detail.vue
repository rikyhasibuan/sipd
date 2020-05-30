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
                <div class="pull-left">
                    <a v-if="approval_tab.lock === 0 && access.write === 1" :href="route + '/sekretaris/create?dinasbop=' + dinasbop.id" class="btn btn-success mb-2 mr-2"><i class="fa fa-plus"></i> Tambah Data</a>
                    <span v-if="dinasbopsekretaris.length !== 0 && access.approval === 1">
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
                <!-- tampil sekretaris -->
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
                            <tr v-for="v in dinasbopsekretaris" :key="v.id">
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
                                    {{ v.sekretaris.nama }}
                                </td>
                                <td style="text-align: center; vertical-align:middle;">
                                    {{ v.sekretaris.hari }} hari x Rp.{{ v.sekretaris.biaya | rupiah }} = Rp.{{ v.sekretaris.total | rupiah }}
                                </td>
                                <td style="text-align: center; vertical-align:middle;">
                                    <div style="text-align: center;">
                                        <a v-if="approval_tab.lock === 0 && access.update === 1" :href="route + '/sekretaris/edit?dinasbop='+ dinasbop.id +'&id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
                                            <i class="fa fa-wrench"></i> Ubah
                                        </a>
                                        <button v-else class="btn btn-sm btn-warning disabled mr-sm-1"><i class="fa fa-wrench"></i> Ubah</button>
                                        <a v-if="approval_tab.lock === 0 && access.delete === 1" href="#" @click="toggleModal(v.id)"
                                           class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash-o"></i> Hapus
                                        </a>
                                        <button v-else class="btn btn-sm btn-danger disabled"><i class="fa fa-trash-o"></i> Hapus</button>
                                        <div class="btn-group" v-if="approval_tab.lock === 1">
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
                                <td style="text-align:right;"><b>Rp.{{ total_anggaran_sekretaris | rupiah }}</b></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </transition>
            </div>
            <div class="col-md-12 col-xs-12" v-if="dinasbopsekretaris.length !== 0">
                <hr>
                <transition name="fade"><v-revision-log :element="element" :revision=approval_tab></v-revision-log></transition>
                <transition name="fade"><v-revision :role="approval_role" :element="'sekretaris_revision_modal'" @revision="createRevision"></v-revision></transition>
                <transition name="fade"><v-approval :role="approval_role" :element="'sekretaris_approval_modal'" @approve="createApproval"></v-approval></transition>
            </div>
        </div>

        <transition name="fade"><v-delete :element="'sekretaris_delete_modal'" :id="sekretarisid" @delete="deleteData"></v-delete></transition>
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
            sekretarisid:'',
            total_anggaran_sekretaris : 0,
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
            element: {
                kassubag_href: '#sekretarisrevlogkassubag',
                kassubag_id: 'sekretarisrevlogkassubag',
                sekretaris_href: '#sekretarisrevlogsekretaris',
                sekretaris_id: 'sekretarisrevlogsekretaris',
                inspektur_href: '#sekretarisrevloginspektur',
                inspektur_id: 'sekretarisrevloginspektur'
            },
            approval_role:''
        }
    },
    props: ['dinasbop', 'dinasbopapproval', 'dinasbopsekretaris', 'route', 'print_action', 'api', 'access', 'approval_type'],
    methods: {
        print_sp(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/sp/'+ id +'/sekretaris';
        },
        print_spd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/spd/'+ id +'/sekretaris';
        },
        print_rbpd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/rbpd/'+ id +'/sekretaris';
        },
        print_personil_all(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/all/'+ id +'/sekretaris';
        },
        print_dpbo(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/dpbo/'+ id +'/sekretaris';
        },
        toggleModal(id) {
            $('#sekretaris_delete_modal').modal('show');
            this.sekretarisid = id;
        },
        toggleRevisiModal(role) {
            this.approval_role = role;
            $("#sekretaris_revision_modal").modal('show');
        },
        toggleApprovalModal(role) {
            this.approval_role = role;
            $("#sekretaris_approval_modal").modal('show');
        },
        deleteData(id) {
            service.deleteData(this.api + '/sekretaris/' + this.dinasbop.id + '/' + id)
            .then(response => {
                if(response.status === 'ok') {
                    this.alert.delete = true;
                    this.sekretarismodal = false;
                    $('#delete_sekretaris_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(function() { this.alert.delete=false; location.reload(); }, 1000);
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                this.sekretarismodal = false;
                $('#delete_sekretaris_modal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        },
        createRevision(callback) {
            service.putData(this.api + '/approval?act=revision&type='+callback.role+'&tab=sekretaris&id=' + this.dinasbop.id, {catatan: callback.catatan})
            .then(response => {
                if(response.status === 'ok') {
                    $('#sekretaris_revision_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    alert('CATATAN REVISI BERHASIL DIBUAT');
                    location.reload();
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                $('#sekretaris_revision_modal').modal('hide');
                alert('TERJADI KESALAHAN PADA SISTEM!');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        },
        createApproval(role) {
            service.putData(this.api + '/approval?act=approve&type='+role+'&tab=sekretaris&id=' + this.dinasbop.id)
                .then(response => {
                    if(response.status === 'ok') {
                        $('#sekretaris_approval_modal').modal('hide');
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                        alert('PROSES APPROVAL BERHASIL');
                        location.reload();
                    }
                }).catch(error => {
                $('#sekretaris_approval_modal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                alert('TERJADI KESALAHAN PADA SISTEM!');
                console.log(error);
            });
        }
    },
    created() {
        this.isLoading = true;
        if (this.dinasbopsekretaris.length === 0) {
            this.showTable = false;
            this.alert.empty = true;
        } else {
            this.showTable = true;
            for (let index = 0; index < this.dinasbopsekretaris.length; index++) {
                this.total_anggaran_sekretaris += this.dinasbopsekretaris[index]['total'];
            }
            this.alert.empty = false;
        }
    },
    mounted() {
        this.isLoading = false;
        this.approval_tab = this.dinasbopapproval.find(dinasbopapproval => dinasbopapproval.tab === 'sekretaris');
    }
};
</script>
