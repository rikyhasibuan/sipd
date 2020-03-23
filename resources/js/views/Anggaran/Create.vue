<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <v-alert :alert=alert></v-alert>
                        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                        <form method="POST" v-on:submit.prevent="onSubmit">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Program *</label>
                                    <select v-model="anggaran.program_id" class="form-control" required="required" @change="onChangeProgram($event)">
                                        <option value="">Pilih Program</option>
                                        <option v-for="v in this.program" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_program }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Kegiatan *</label>
                                    <select v-model="anggaran.kegiatan_id" class="form-control" required="required" @change="onChangeKegiatan($event)">
                                        <option value="">Pilih Kegiatan</option>
                                        <option v-for="v in this.kegiatan" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_kegiatan }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Belanja *</label>
                                    <select v-model="anggaran.belanja_id" class="form-control" required="required">
                                        <option value="">Pilih Belanja</option>
                                        <option v-for="v in this.belanja" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_belanja }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama">Jumlah Anggaran *</label>
                                    <input type="text" class="form-control" v-model="anggaran.jumlah" required="required">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Bulan *</label>
                                    <select v-model="anggaran.bulan" class="form-control" required="required">
                                        <option value="">Pilih Bulan</option>
                                        <option v-for="(v,k) in this.bulan_data" v-bind:value="k" v-bind:key="k">{{ v }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Tahun *</label>
                                    <select v-model="anggaran.tahun" class="form-control" required="required">
                                        <option value="">Pilih Tahun</option>
                                        <option v-for="v in this.tahun_data" v-bind:value="v" v-bind:key="v">{{ v }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                    <a :href="route" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
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
                anggaran: {
                    'program_id': '',
                    'kegiatan_id': '',
                    'belanja_id': '',
                    'jumlah': '',
                    'bulan': '',
                    'tahun': ''
                },
                program:'',
                belanja:'',
                kegiatan:'',
                alert: {
                    error: false,
                    save: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: ['program_data','kegiatan_data','belanja_data','bulan_data','tahun_data', 'api', 'route'],
        methods: {
            onChangeProgram(evt) {
                const program = evt.target.value;
                // ambil data kegiatan berdasarkan program
                service.fetchData('../api/ajax/kegiatan/' + program)
                .then(response => {
                    this.anggaran.kegiatan_id = '';
                    this.anggaran.belanja_id = '';
                    this.kegiatan = response;
                    this.belanja = [];
                })
                .catch(error => {
                    console.log(error);
                });
            },
            onChangeKegiatan(evt) {
                const kegiatan = evt.target.value;
                // ambil data kegiatan berdasarkan program
                service.fetchData('../api/ajax/belanja/' + kegiatan)
                .then(response => {
                    this.anggaran.belanja_id = '';
                    this.belanja = response;
                })
                .catch(error => {
                    console.log(error);
                });
            },
            onSubmit(evt) {
                service.postData(this.api, this.anggaran)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.$Progress.finish();
                        this.errorAlert = true;
                        this.saveAlert = false;
                        this.duplicateAlert = false;
                        window.scroll({
                            top: 0,
                            left: 0,
                            behavior: 'smooth'
                        });
                        console.log(error);
                    });
            },
            response(result) {
                if (result.status === 'OK') {
                    this.alert.error = false;
                    this.alert.duplicate = false;
                    this.alert.save = true;
                    window.scroll({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    })
                    this.reset();
                    setTimeout(() => this.alert.save = false, 5000);
                } else if (result.status === 'DUPLICATE') {
                    this.alert.duplicate = true;
                    this.alert.error = false;
                    this.alert.save = false;
                    window.scroll({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    });
                }
            },
            reset() {
                this.anggaran.program_id = '';
                this.anggaran.kegiatan_id = '';
                this.anggaran.belanja_id = '';
                this.anggaran.jumlah = '';
                this.anggaran.bulan = '';
                this.anggaran.tahun = '';
            }
        },
        created() {
            this.isLoading = true;
            this.program = this.program_data;
            this.belanja = this.belanja_data;
            this.kegiatan = this.kegiatan_data;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>