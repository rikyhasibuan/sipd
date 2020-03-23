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
                                <div class="form-group col-md-4">
                                    <label for="bidang">Program *</label>
                                    <select v-model="dinasbop.program_id" @change="onChangeProgram($event)" class="form-control" required="required">
                                        <option value="">Pilih Program</option>
                                        <option v-for="v in this.program_data" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_program }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="bidang">Kegiatan *</label>
                                    <select v-model="dinasbop.kegiatan_id" @change="onChangeKegiatan($event)" class="form-control" required="required">
                                        <option value="">Pilih Kegiatan</option>
                                        <option v-for="v in this.kegiatan_data" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_kegiatan }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="bidang">Belanja *</label>
                                    <select v-model="dinasbop.belanja_id" class="form-control" required="required">
                                        <option value="">Pilih Belanja</option>
                                        <option v-for="v in this.belanja_data" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_belanja }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nama">Dasar *</label>
                                    <textarea class="form-control" v-model="dinasbop.dasar[0]" required="required" rows="3"></textarea>
                                    <br>
                                    <textarea class="form-control" v-model="dinasbop.dasar[1]" rows="3"></textarea>
                                    <br>
                                    <textarea class="form-control" v-model="dinasbop.dasar[2]" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nama">Peruntukan *</label>
                                    <textarea class="form-control" v-model="dinasbop.untuk" required="required" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama">Tanggal Mulai *</label>
                                    <input type="date" class="form-control" v-model="dinasbop.dari" required="required">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nama">Tanggal Selesai *</label>
                                    <input type="date" class="form-control" v-model="dinasbop.sampai" required="required">
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
                dinasbop: {
                    'program_id': '',
                    'kegiatan_id': '',
                    'belanja_id': '',
                    'dasar': [],
                    'tujuan': '',
                    'untuk': '',
                    'dari': '',
                    'sampai': ''
                },
                program:'',
                kegiatan:'',
                belanja:'',
                alert: {
                    error: false,
                    save: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: [
            'program_data',
            'kegiatan_data',
            'belanja_data',
            'tujuan_data',
            'irban_data',
            'api',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                service.postData(this.api, this.dinasbop)
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
            onChangeProgram(evt) {
                const program = evt.target.value;
                if (program !== '') {
                    service.fetchData('../api/ajax/kegiatan/'+ program)
                    .then(response => {
                        this.dinasbop.kegiatan_id = '';
                        this.dinasbop.belanja_id = '';
                        this.kegiatan = response;
                    })
                    .catch(error => {
                        console.log(error);
                    });
                } else {
                    this.dinasbop.kegiatan_id = '';
                    this.dinasbop.belanja_id = '';
                    this.kegiatan = [];
                    this.belanja = [];
                }
            },
            onChangeKegiatan(evt) {
                const kegiatan = evt.target.value;
                if (kegiatan !== '') {
                    service.fetchData('../api/ajax/belanja/'+ kegiatan)
                    .then(response => {
                        this.dinasbop.belanja_id = '';
                        this.belanja = response;
                    })
                    .catch(error => {
                        console.log(error);
                    });
                } else {
                    this.dinasbop.belanja_id = '';
                    this.belanja = [];
                }
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
                    setTimeout(() => this.alert.save = false, 2000);
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
                this.dinasbop.program_id = '';
                this.dinasbop.kegiatan_id = '';
                this.dinasbop.belanja_id = '';
                this.dinasbop.dasar = '';
                this.dinasbop.untuk = '';
                this.dinasbop.dari = '';
                this.dinasbop.sampai = '';
            }
        },
        created() {
            this.isLoading = true;
            this.program = this.program_data;
            this.kegiatan = this.kegiatan_data;
            this.belanja = this.belanja_data;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>