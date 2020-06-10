<template>
    <div>
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
                                    <select v-model="belanja.program_id" @change="onChangeProgram($event)" class="form-control" :class="{ 'is-invalid': validasi.program_id }">
                                        <option value="">Pilih Program</option>
                                        <option v-for="v in this.program" :value="v.id" :key="v.id">{{ v.nama_program }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Kegiatan *</label>
                                    <select v-model="belanja.kegiatan_id" class="form-control" :class="{ 'is-invalid': validasi.kegiatan_id }">
                                        <option value="">Pilih Kegiatan</option>
                                        <option v-for="v in this.kegiatan" :value="v.id" :key="v.id">{{ v.nama_kegiatan }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Kode Belanja *</label>
                                    <input type="text" class="form-control" v-model="belanja.kode_belanja" :class="{ 'is-invalid': validasi.kode_belanja }">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama Belanja *</label>
                                    <input type="text" class="form-control" v-model="belanja.nama_belanja" :class="{ 'is-invalid': validasi.nama_belanja }">
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
    </div>
</template>

<script>
    import service from './../../services.js';

    export default {
        data() {
            return {
                validasi: {
                    'program_id': '',
                    'kegiatan_id': '',
                    'kode_belanja': '',
                    'nama_belanja': ''
                },
                program:[],
                kegiatan:[],
                alert: {
                    error: false,
                    update: false,
                    validate: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: ['program_data','kegiatan_data', 'belanja', 'api', 'route'],
        methods: {
            clearAlert() {
                this.alert.error = false;
                this.alert.update = false;
                this.alert.duplicate = false;
                this.alert.validate = false;
            },
            onSubmit(evt) {
                evt.preventDefault();
                this.clearAlert();
                let validasi = this.validate();

                if (validasi === true) {
                    this.isLoading = true;
                    service.putData(this.api, this.belanja)
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
            onChangeProgram(evt) {
                const program = evt.target.value;
                service.fetchData('../api/ajax/kegiatan/' + program)
                .then(response => {
                    this.belanja.kegiatan_id = '';
                    this.kegiatan = response;
                }).catch(error => {
                    console.log(error);
                });
            },
            response(result) {
                setTimeout(() => { this.isLoading = false }, 1000);
                if (result.status === 'ok') {
                    this.alert.update = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(() => this.alert.update = false, 5000);
                } else if (result.status === 'duplicate') {
                    this.alert.duplicate = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(() => this.alert.update = false, 5000);
                }
            },
            validate() {
                let condition = 0;

                if (this.belanja.program_id.length === 0) {
                    this.validasi.program_id = true;
                    condition++;
                } else {
                    this.validasi.program_id = false;
                }

                if (this.belanja.kegiatan_id.length === 0) {
                    this.validasi.kegiatan_id = true;
                    condition++;
                } else {
                    this.validasi.kegiatan_id = false;
                }

                if (this.belanja.kode_belanja.length === 0) {
                    this.validasi.kode_belanja = true;
                    condition++;
                } else {
                    this.validasi.kode_belanja = false;
                }

                if (this.belanja.nama_belanja.length === 0) {
                    this.validasi.nama_belanja = true;
                    condition++;
                } else {
                    this.validasi.nama_belanja = false;
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
            this.program = this.program_data;
            this.kegiatan = this.kegiatan_data;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
