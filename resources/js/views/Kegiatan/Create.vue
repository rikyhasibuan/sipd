<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :opacity="100" :active.sync="isLoading" :can-cancel="false" :is-full-page="false"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Program *</label>
                                <select v-model="kegiatan.program_id" class="form-control" :class="{ 'is-invalid': validasi.program_id }">
                                    <option value="">Pilih Program</option>
                                    <option v-for="v in this.program_data" :value="v.id" :key="v.id">{{ v.nama_program }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Bendahara *</label>
                                <select v-model="kegiatan.bendahara" class="form-control" :class="{ 'is-invalid': validasi.bendahara }">
                                    <option value="">Pilih Bendahara</option>
                                    <option v-for="v in this.bendahara_data" :value="v.id" :key="v.id">{{ v.nama }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Kode Kegiatan *</label>
                                <input type="text" class="form-control" placeholder="Masukkan Kode Kegiatan" v-model="kegiatan.kode_kegiatan" :class="{ 'is-invalid': validasi.kode_kegiatan }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nama Kegiatan *</label>
                                <input type="text" class="form-control" placeholder="Masukkan Nama Kegiatan" v-model="kegiatan.nama_kegiatan" :class="{ 'is-invalid': validasi.nama_kegiatan }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                <a :href="route" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>*) Wajib Diisi</b>
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
                kegiatan: {
                    'program_id': '',
                    'bendahara': '',
                    'kode_kegiatan': '',
                    'nama_kegiatan': ''
                },
                validasi: {
                    'program_id': '',
                    'bendahara': '',
                    'kode_kegiatan': '',
                    'nama_kegiatan': ''
                },
                alert: {
                    error: false,
                    save: false,
                    duplicate: false,
                    validate: false
                },
                isLoading: false
            }
        },
        props: ['bendahara_data','program_data', 'api', 'route'],
        methods: {
            clearAlert() {
                this.alert.error = false;
                this.alert.save = false;
                this.alert.duplicate = false;
                this.alert.validate = false;
            },
            onSubmit(evt) {
                evt.preventDefault();
                this.clear();
                let validasi = this.validate();
                if (validasi === true) {
                    this.isLoading = true;
                    service.postData(this.api, this.kegiatan)
                        .then(result => {
                            this.response(result);
                        }).catch(error => {
                            this.isLoading = false;
                            this.alert.error = true;
                            window.scroll({top: 0, left: 0, behavior: 'smooth'});
                            console.log(error);
                        });
                } else {
                    this.alert.validate = true;
                    setTimeout(() => this.alert.validate = false, 2000);
                }
            },
            response(result) {
                setTimeout(() => { this.isLoading = false }, 1000);
                if (result.status === 'ok') {
                    this.alert.save = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    this.reset();
                    setTimeout(() => this.alert.save = false, 5000);
                } else if (result.status === 'duplicate') {
                    this.alert.duplicate = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                }
            },
            reset() {
                this.kegiatan.program_id = '';
                this.kegiatan.bendahara = '';
                this.kegiatan.kode_kegiatan = '';
                this.kegiatan.nama_kegiatan = '';
            },
            validate() {
                let condition = 0;

                if (this.kegiatan.program_id.length === 0) {
                    this.validasi.program_id = true;
                    condition++;
                } else {
                    this.validasi.program_id = false;
                }

                if (this.kegiatan.bendahara.length === 0) {
                    this.validasi.bendahara = true;
                    condition++;
                } else {
                    this.validasi.bendahara = false;
                }

                if (this.kegiatan.kode_kegiatan.length === 0) {
                    this.validasi.kode_kegiatan = true;
                    condition++;
                } else {
                    this.validasi.kode_kegiatan = false;
                }

                if (this.kegiatan.nama_kegiatan.length === 0) {
                    this.validasi.nama_kegiatan = true;
                    condition++;
                } else {
                    this.validasi.nama_kegiatan = false;
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
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
