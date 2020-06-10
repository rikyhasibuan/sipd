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
                                <label>Irban *</label>
                                <select v-model="irbanskpd.irban_id" class="form-control mb-2 mr-sm-2" :class="{ 'is-invalid': validasi.irban_id }">
                                    <option value="">Pilih Irban</option>
                                    <option v-for="val in this.irban_data" :value="val.id" :key="val.id">{{ val.nama_irban }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Perangkat Daerah *</label>
                                <select v-model="irbanskpd.skpd_id" class="form-control mb-2 mr-sm-2" :class="{ 'is-invalid': validasi.skpd_id }">
                                    <option value="">Pilih Perangkat Daerah</option>
                                    <option v-for="obj in this.skpd_data" :value="obj.id" :key="obj.id">{{ obj.nama_skpd }}</option>
                                </select>
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
            irbanskpd: {
                irban_id:'',
                skpd_id:''
            },
            validasi: {
                irban_id:'',
                skpd_id:''
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
    props: ['api', 'irban_data', 'skpd_data', 'route'],
    methods: {
        clearAlert() {
            this.alert.error = false;
            this.alert.save = false;
            this.alert.duplicate = false;
            this.alert.validate = false;
        },
        reset() {
            this.irbanskpd.skpd_id = '';
            this.irbanskpd.irban_id = '';
        },
        onSubmit(evt) {
            evt.preventDefault();
            this.clearAlert();
            let validasi = this.validate();
            if (validasi === true) {
                this.isLoading = true;
                service.postData(this.api, this.irbanskpd)
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

            if (this.irbanskpd.skpd_id.length === 0) {
                this.validasi.skpd_id = true;
                condition++;
            } else {
                this.validasi.skpd_id = false;
            }

            if (this.irbanskpd.irban_id.length === 0) {
                this.validasi.irban_id = true;
                condition++;
            } else {
                this.validasi.irban_id = false;
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
