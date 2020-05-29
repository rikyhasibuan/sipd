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
                        <td>
                            <div v-if="dinasbopreviu.dasar.length > 1">
                                <ol style="margin-left:-25px;">
                                    <li v-for="(v,k) in dinasbopreviu.dasar" :key="k">
                                        {{ v }}
                                    </li>
                                </ol>
                            </div>
                            <div v-else>
                                {{ dinasbopreviu.dasar[0] }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><b>Waktu Pemeriksaan</b></td>
                        <td style="width:85%;">{{ dinasbopreviu.dari | moment }} s.d {{ dinasbopreviu.sampai | moment }}</td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><b>Tujuan Pemeriksaan</b></td>
                        <td>
                            <div v-if="dinasbopreviu.tujuan.length > 1">
                                <ol style="margin-left:-25px;">
                                    <li v-for="(v,k) in dinasbopreviu.tujuan" :key="k">
                                        {{ v }}
                                    </li>
                                </ol>
                            </div>
                            <div v-else>
                                {{ dinasbopreviu.tujuan[0] }}
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
                <div class="pull-left">
                    <span v-if="dinasbopreviu === null">
                        <a v-if="access.write === 1" :href="route + '/reviu/create?dinasbop=' + dinasbop.id" class="btn btn-success mb-2 mr-2"><i class="fa fa-plus"></i> Tambah Tim Reviu & Monitoring</a>
                    </span>
                    <span v-else>
                        <a v-if="approval_tab.lock === 0 && access.update === 1" :href="route + '/reviu/edit?id='+dinasbopreviu.id+'&dinasbop=' + dinasbop.id" class="btn btn-warning mb-2 mr-2"><i class="fa fa-wrench"></i> Ubah Tim Reviu & Monitoring</a>
                        <div class="btn-group" v-if="approval_tab.lock === 1">
                            <button type="button" class="btn btn-default mb-2"><i class="fa fa-print"></i> Print</button>
                            <button type="button" class="btn btn-default mb-2 dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="#" @click="print_sp(dinasbopreviu.id)">Surat Perintah</a>
                                    <a class="dropdown-item" href="#" @click="print_spd(dinasbopreviu.id)">Surat Perjalanan Dinas (SPD)</a>
                                    <a class="dropdown-item" href="#" @click="print_rbpd(dinasbopreviu.id)">Rincian Biaya Perjalanan Dinas</a>
                                    <a class="dropdown-item" href="#" @click="print_dpbo(dinasbopreviu.id)">Daftar Pembayaran</a>
                                </div>
                            </button>
                        </div>
                    </span>
                    <span v-if="dinasbopreviu !== null && access.approval === 1">
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
                                <th style="width:5%;text-align:center;">NIP</th>
                                <th style="width:12%;text-align:center;">Nama</th>
                                <th style="width:12%;text-align:center;">Jabatan</th>
                                <th style="width:5%;text-align:center;">Peran</th>
                                <th style="width:12%;text-align:center;">Rincian Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ dinasbopreviu.tim.ketuatim.nip }}</td>
                                <td>{{ dinasbopreviu.tim.ketuatim.nama }}</td>
                                <td>{{ dinasbopreviu.tim.ketuatim.jabatan }}</td>
                                <td style="text-align:center;">Ketua Tim</td>
                                <td style="text-align:right;">
                                    {{ dinasbopreviu.tim.ketuatim.hari }} hari x
                                    Rp.{{ dinasbopreviu.tim.ketuatim.biaya | rupiah }} =
                                    Rp.{{ dinasbopreviu.tim.ketuatim.total | rupiah }}
                                </td>
                            </tr>
                            <tr v-for="v in dinasbopreviu.tim.anggota" :key="v.nip">
                                <td>{{ v.nip }}</td>
                                <td>{{ v.nama }}</td>
                                <td>{{ v.jabatan }}</td>
                                <td style="text-align:center;">Anggota</td>
                                <td style="text-align:right;">
                                    {{
                                        v.hari }} hari x
                                    Rp.{{ v.biaya | rupiah }} =
                                    Rp.{{ v.total | rupiah }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="text-align:right;"><b>Jumlah</b></td>
                                <td style="text-align:right;"><b>Rp.{{ dinasbopreviu.total_anggaran | rupiah }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </transition>
            </div>
            <div class="col-md-12 col-xs-12" v-if="dinasbopreviu !== null">
                <hr>
                <transition name="fade"><v-revision-log :revision=approval_tab></v-revision-log></transition>
                <transition name="fade"><v-revision :role="approval_role" :element="'reviu_revision_modal'" @revision="createRevision"></v-revision></transition>
                <transition name="fade"><v-approval :role="approval_role" :element="'reviu_approval_modal'" @approve="createApproval"></v-approval></transition>
            </div>
        </div>
    </div>
</template>

<script>
import service from "../../services";

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
            approval_role:''
        }
    },
    props: ['dinasbop', 'dinasbopapproval', 'dinasbopreviu', 'route', 'print_action', 'api', 'access', 'approval_type'],
    methods: {
        print_sp(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/sp/'+ id +'/reviu';
        },
        print_spd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/spd/'+ id +'/reviu';
        },
        print_rbpd(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/rbpd/'+ id +'/reviu';
        },
        print_personil(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/'+ id +'/reviu';
        },
        print_personil_all(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/personil/all/'+ id;
        },
        print_dpbo(id) {
            let new_window = window.open();
            new_window.location = this.api + '/print/dpbo/'+ id +'/reviu';
        },
        toggleRevisiModal(role) {
            this.approval_role = role;
            $("#reviu_revision_modal").modal('show');
        },
        toggleApprovalModal(role) {
            this.approval_role = role;
            $("#reviu_approval_modal").modal('show');
        },
        createRevision(callback) {
            service.putData(this.api + '/approval?act=revision&type='+callback.role+'&tab=reviu&id=' + this.dinasbop.id, {catatan: callback.catatan})
            .then(response => {
                if(response.status === 'ok') {
                    $('#reviu_revision_modal').modal('hide');
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    alert('CATATAN REVISI BERHASIL DIBUAT');
                    location.reload();
                }
            }).catch(error => {
                this.alert.delete = false;
                this.alert.error = true;
                $('#reviu_revision_modal').modal('hide');
                alert('TERJADI KESALAHAN PADA SISTEM!');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        },
        createApproval(role) {
            service.putData(this.api + '/approval?act=approve&type='+role+'&tab=reviu&id=' + this.dinasbop.id)
                .then(response => {
                    if(response.status === 'ok') {
                        $('#reviu_approval_modal').modal('hide');
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                        alert('PROSES APPROVAL BERHASIL');
                        location.reload();
                    }
                }).catch(error => {
                $('#reviu_approval_modal').modal('hide');
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                alert('TERJADI KESALAHAN PADA SISTEM!');
                console.log(error);
            });
        }
    },
    created() {
        this.isLoading = true;
        if (this.dinasbopreviu === null) {
            this.showTable = false;
            this.alert.empty = true;
        } else {
            this.showTable = true;
            this.alert.empty = false;
            let x = 0;
            for (x in this.dinasbopreviu) {
                this.total_biaya_tim += this.dinasbopreviu[x].total_anggaran;
            }
        }
    },
    mounted() {
        this.isLoading = false;
        this.approval_tab = this.dinasbopapproval.find(dinasbopapproval => dinasbopapproval.tab === 'reviu');
    }
};
</script>
