<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <transition name="fade">
                            <v-alert :alert=alert></v-alert>
                        </transition>
                        <loading :opacity="100" :active.sync="isLoading" :can-cancel="false" :is-full-page="false"></loading>
                        <form method="POST" v-on:submit.prevent="onSubmit">
                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12">
                                    <label>NIP *</label>
                                    <input type="text" class="form-control" v-model="pegawai.nip" :class="{ 'is-invalid': validasi.nip }">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12">
                                    <label>Nama *</label>
                                    <input type="text" class="form-control" v-model="pegawai.nama" :class="{ 'is-invalid': validasi.nama }">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12">
                                    <label>Pangkat *</label>
                                    <select v-model="pegawai.pangkat" class="form-control" @change="onChangePangkat($event)" :class="{ 'is-invalid': validasi.pangkat }">
                                        <option value="">Pilih Pangkat</option>
                                        <option v-for="v in this.pangkat_data" :value="v.nama_pangkat" :key="v.id">
                                            {{ v.nama_pangkat }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12">
                                    <label>Jabatan *</label>
                                    <select v-model="pegawai.jabatan" class="form-control" :class="{ 'is-invalid': validasi.jabatan }">
                                        <option value="">Pilih Jabatan</option>
                                        <option v-for="v in this.jabatan_data" :value="v.nama_jabatan" :key="v.id">
                                            {{ v.nama_jabatan }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-xs-12">
                                    <label>Eselon</label>
                                    <select v-model="pegawai.eselon" class="form-control">
                                        <option value="">Pilih Eselon</option>
                                        <option v-for="(k,v) in this.eselon_data" v-bind:value="k" v-bind:key="k">
                                            {{ v }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 col-xs-12">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                    <a :href="route" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 col-xs-12">
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
            pegawai: {
                'nip': '',
                'nama': '',
                'pangkat': '',
                'golongan': '',
                'jabatan': '',
                'eselon': ''
            },
            validasi: {
                'nip': '',
                'nama': '',
                'pangkat': '',
                'golongan': '',
                'jabatan': ''
            },
            alert: {
                error: false,
                save: false,
                duplicate: false,
                validate:false
            },
            isLoading: false
        }
    },
    props: ['pangkat_data', 'jabatan_data', 'eselon_data', 'api', 'route'],
    methods: {
        clearAlert() {
            this.alert.error = false;
            this.alert.save = false;
            this.alert.duplicate = false;
            this.alert.validate = false;
        },
        onSubmit(evt) {
            evt.preventDefault();
            this.clearAlert();
            let validasi = this.validate();
            if (validasi === true) {
                this.isLoading = true;
                service.postData(this.api, this.pegawai)
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
        onChangePangkat(evt) {
            const pangkat = evt.target.value;
            service.postData('../api/ajax/golongan', {'pangkat': pangkat})
            .then(response => {
                this.pegawai.golongan = response.golongan;
            })
            .catch(error => {
                console.log(error);
            });
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
        validate() {
            let condition = 0;
            if (this.pegawai.nip.length === 0) {
                this.validasi.nip = true;
                condition++;
            } else {
                this.validasi.nip = false;
            }

            if (this.pegawai.nama.length === 0) {
                this.validasi.nama = true;
                condition++;
            } else {
                this.validasi.nama = false;
            }

            if (this.pegawai.pangkat.length === 0) {
                this.validasi.pangkat = true;
                condition++;
            } else {
                this.validasi.pangkat = false;
            }

            if (this.pegawai.jabatan.length === 0) {
                this.validasi.jabatan = true;
                condition++;
            } else {
                this.validasi.jabatan = false;
            }

            if (condition > 0) {
                return false;
            } else {
                return true;
            }
        },
        reset() {
            this.pegawai.nip = '';
            this.pegawai.nama = '';
            this.pegawai.pangkat = '';
            this.pegawai.jabatan = '';
            this.pegawai.eselon = '';
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
