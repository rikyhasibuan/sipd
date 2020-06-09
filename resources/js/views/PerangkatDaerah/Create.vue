<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <v-alert :alert=alert></v-alert>
                        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                        <transition name="fade">
                            <form method="POST" v-on:submit.prevent="onSubmit">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Nama Perangkat Daerah *</label>
                                        <input type="text" class="form-control" id="nama_skpd" v-model="skpd.nama_skpd" placeholder="Nama Perangkat Daerah" :class="{ 'is-invalid': validasi.nama_skpd }">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Kontak *</label>
                                        <input type="text" class="form-control" id="kontak" v-model="skpd.kontak" placeholder="Nomor Telepon" :class="{ 'is-invalid': validasi.kontak }">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Alamat *</label>
                                        <textarea class="form-control" id="alamat" v-model="skpd.alamat" :class="{ 'is-invalid': validasi.alamat }"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Kota *</label>
                                        <select v-model="skpd.kota" class="form-control" :class="{ 'is-invalid': validasi.kota }">
                                            <option value="">Pilih Kota</option>
                                            <option v-for="v in this.kabkota" :value="v.nama_kabkota" :key="v.id">
                                                {{ v.nama_kabkota }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
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
                        </transition>
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
            skpd : {
                nama_skpd: '',
                kontak:'',
                alamat:'',
                kota:''
            },
            validasi: {
                'nama_skpd': '',
                'kontak': '',
                'alamat': '',
                'kota': ''
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
    props: ['api','route','kabkota'],
    methods: {
        clearAlert() {
            this.alert.error = false;
            this.alert.save = false;
            this.alert.duplicate = false;
            this.alert.validate = false;
        },
        reset() {
            this.skpd.nama_skpd = '';
            this.skpd.alamat = '';
            this.skpd.kontak = '';
            this.skpd.kota = '';
        },
        onSubmit (evt) {
            evt.preventDefault();
            this.clearAlert();
            let validasi = this.validate();
            if (validasi === true) {
                this.isLoading = true;
                service.postData(this.api, this.skpd)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.isLoading = false;
                        this.alert.error = true;
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
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
        validate() {
            let condition = 0;

            if (this.skpd.nama_skpd.length === 0) {
                this.validasi.nama_skpd = true;
                condition++;
            } else {
                this.validasi.nama_skpd = false;
            }

            if (this.skpd.kontak.length === 0) {
                this.validasi.kontak = true;
                condition++;
            } else {
                this.validasi.kontak = false;
            }

            if (this.skpd.alamat.length === 0) {
                this.validasi.alamat = true;
                condition++;
            } else {
                this.validasi.alamat = false;
            }

            if (this.skpd.kota.length === 0) {
                this.validasi.kota = true;
                condition++;
            } else {
                this.validasi.kota = false;
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
