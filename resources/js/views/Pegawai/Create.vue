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
                                    <label>NIP *</label>
                                    <input type="text" class="form-control" v-model="pegawai.nip" required="required">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama *</label>
                                    <input type="text" class="form-control" v-model="pegawai.nama" required="required">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Pangkat *</label>
                                    <select v-model="pegawai.pangkat" class="form-control" required="required">
                                        <option value="">Pilih Pangkat</option>
                                        <option v-for="v in this.pangkat_data" :value="v.nama_pangkat" :key="v.id">
                                            {{ v.nama_pangkat }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Golongan *</label>
                                    <select v-model="pegawai.golongan" class="form-control" required="required">
                                        <option value="">Pilih Golongan</option>
                                        <option v-for="(k,v) in this.golongan_data" :value="k" :key="k">{{ v }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Jabatan *</label>
                                    <select v-model="pegawai.jabatan" class="form-control" required="required">
                                        <option value="">Pilih Jabatan</option>
                                        <option v-for="v in this.jabatan_data" :value="v.nama_jabatan" :key="v.id">
                                            {{ v.nama_jabatan }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Eselon</label>
                                    <select v-model="pegawai.eselon" class="form-control">
                                        <option value="">Pilih Eselon</option>
                                        <option v-for="(k,v) in this.eselon_data" v-bind:value="k" v-bind:key="k">
                                            {{ v }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Simpan Data</button>
                                    <a :href="route" class="btn btn-danger"><i class="fa fa-arrow-left"></i>
                                        Kembali</a>
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
            alert: {
                error: false,
                save: false,
                duplicate: false
            },
            isLoading: false
        }
    },
    props: ['golongan_data', 'pangkat_data', 'jabatan_data', 'eselon_data', 'api', 'route'],
    methods: {
        onSubmit(evt) {
            this.isLoading = true;
            service.postData(this.api, this.pegawai)
                .then(result => {
                    this.isLoading = false;
                    this.response(result);
                }).catch(error => {
                    this.isLoading = false;
                    this.alert.error = true;
                    this.alert.duplicate = false;
                    this.alert.save = false;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    console.log(error);
                });
        },
        response(result) {
            if (result.status === 'ok') {
                this.alert.error = false;
                this.alert.duplicate = false;
                this.alert.save = true;
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                this.reset();
                setTimeout(() => this.alert.save = false, 5000);
            } else if (result.status === 'duplicate') {
                this.alert.duplicate = true;
                this.alert.error = false;
                this.alert.save = false;
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
            }
        },
        reset() {
            this.pegawai.nip = '';
            this.pegawai.nama = '';
            this.pegawai.pangkat = '';
            this.pegawai.golongan = '';
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
