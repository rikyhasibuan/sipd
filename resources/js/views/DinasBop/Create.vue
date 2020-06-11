<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :opacity="100" :active.sync="isLoading" :can-cancel="false" :is-full-page="false"></loading>
                    <form autocomplete="off" method="POST" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Program *</label>
                                <select v-model="dinasbop.program_id" @change="onChangeProgram($event)" class="form-control" :class="{ 'is-invalid': validasi.program_id }">
                                    <option value="">Pilih Program</option>
                                    <option v-for="v in this.program" :value="v.id" :key="v.id">{{ v.nama_program }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kegiatan *</label>
                                <select v-model="dinasbop.kegiatan_id" @change="onChangeKegiatan($event)" class="form-control" :class="{ 'is-invalid': validasi.kegiatan_id }" >
                                    <option value="">Pilih Kegiatan</option>
                                    <option v-for="v in this.kegiatan" :value="v.id" :key="v.id">{{ v.nama_kegiatan }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Belanja *</label>
                                <select v-model="dinasbop.belanja_id" class="form-control" :class="{ 'is-invalid': validasi.belanja_id }">
                                    <option value="">Pilih Belanja</option>
                                    <option v-for="v in this.belanja" :value="v.id" :key="v.id">{{ v.nama_belanja }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Dasar Surat Perintah (Diisi minimal 1 kolom) *</label>
                                <input type="text" class="form-control" placeholder="Dasar 1" v-model="dinasbop.dasar[0]" :class="{ 'is-invalid': validasi.dasar }">
                                <br>
                                <input type="text" class="form-control" placeholder="Dasar 2" v-model="dinasbop.dasar[1]" :class="{ 'is-invalid': validasi.dasar }">
                                <br>
                                <input type="text" class="form-control" placeholder="Dasar 3" v-model="dinasbop.dasar[2]" :class="{ 'is-invalid': validasi.dasar }">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Tujuan Pemeriksaan (Diisi minimal 1 kolom) *</label>
                                <input type="text" class="form-control" placeholder="Tujuan 1" v-model="dinasbop.untuk[0]" :class="{ 'is-invalid': validasi.untuk }">
                                <br>
                                <input type="text" class="form-control" placeholder="Tujuan 2" v-model="dinasbop.untuk[1]" :class="{ 'is-invalid': validasi.untuk }">
                                <br>
                                <input type="text" class="form-control" placeholder="Tujuan 3" v-model="dinasbop.untuk[2]" :class="{ 'is-invalid': validasi.untuk }">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Tanggal Mulai *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <date-picker
                                        id="dari"
                                        name="dari"
                                        v-model="dinasbop.dari"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Mulai"
                                        :class="{ 'is-invalid': validasi.dari }"
                                        autocomplete="off">
                                    </date-picker>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Selesai *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <date-picker
                                        id="sampai"
                                        name="sampai"
                                        v-model="dinasbop.sampai"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Selesai"
                                        :class="{ 'is-invalid': validasi.sampai }"
                                        autocomplete="off">
                                    </date-picker>
                                </div>
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
                    'untuk': [],
                    'dari': '',
                    'sampai': ''
                },
                validasi: {
                    'program_id': '',
                    'kegiatan_id': '',
                    'belanja_id': '',
                    'dasar': '',
                    'untuk': '',
                    'dari': '',
                    'sampai': ''
                },
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    locale: 'id'
                },
                program:'',
                kegiatan:'',
                belanja:'',
                alert: {
                    error: false,
                    save: false,
                    duplicatedate: false,
                    validate: false
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
            clearAlert() {
                this.alert.error = false;
                this.alert.save = false;
                this.alert.duplicatedate = false;
                this.alert.validate = false;
            },
            onSubmit(evt) {
                evt.preventDefault();
                this.clearAlert();
                let validasi = this.validate();
                if (validasi === true) {
                    this.isLoading = true;
                    service.postData(this.api, this.dinasbop)
                        .then(result => {
                            this.response(result);
                        }).catch(error => {
                            setTimeout(() => { this.isLoading = false }, 1000);
                            this.alert.error = true;
                            window.scroll({top: 0, left: 0, behavior: 'smooth'});
                            console.log(error);
                        });
                }
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
                setTimeout(() => { this.isLoading = false }, 1000);
                if (result.status === 'ok') {
                    this.alert.save = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    this.reset();
                    setTimeout(() => this.alert.save = false, 2000);
                } else if (result.status === 'duplicate') {
                    this.alert.duplicatedate = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
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
            },
            validate() {
                let condition = 0;

                if (this.dinasbop.program_id.length === 0) {
                    this.validasi.program_id = true;
                    condition++;
                } else {
                    this.validasi.program_id = false;
                }

                if (this.dinasbop.kegiatan_id.length === 0) {
                    this.validasi.kegiatan_id = true;
                    condition++;
                } else {
                    this.validasi.kegiatan_id = false;
                }

                if (this.dinasbop.belanja_id.length === 0) {
                    this.validasi.belanja_id = true;
                    condition++;
                } else {
                    this.validasi.belanja_id = false;
                }

                if (this.dinasbop.dasar.length === 0) {
                    this.validasi.dasar = true;
                    condition++;
                } else {
                    this.validasi.dasar = false;
                }

                if (this.dinasbop.untuk.length === 0) {
                    this.validasi.untuk = true;
                    condition++;
                } else {
                    this.validasi.untuk = false;
                }

                if (this.dinasbop.dari.length === 0) {
                    this.validasi.dari = true;
                    condition++;
                } else {
                    this.validasi.dari = false;
                }

                if (this.dinasbop.sampai.length === 0) {
                    this.validasi.sampai = true;
                    condition++;
                } else {
                    this.validasi.sampai = false;
                }

                if (condition > 0) {
                    return false;
                } else {
                    return true;
                }
            }
        },
        created() {
            this.isLoading = true;
            this.$cookies.set("last_tab", "tim");
            this.program = this.program_data;
            this.kegiatan = this.kegiatan_data;
            this.belanja = this.belanja_data;
        },
        mounted() {
            setTimeout(() => { this.isLoading = false }, 1000);
        }
    };
</script>
