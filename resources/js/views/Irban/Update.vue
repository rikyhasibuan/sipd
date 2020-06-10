<template>
    <vcl-table v-if="placeholder === true"></vcl-table>
    <div v-else>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <v-alert :alert=alert></v-alert>
                        <loading :opacity="100" :active.sync="isLoading" :can-cancel="false" :is-full-page="false"></loading>
                        <form method="POST" v-on:submit.prevent="onSubmit">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama Irban *</label>
                                    <input type="text" class="form-control" v-model="irban.nama_irban" placeholder="Nama Irban" :class="{ 'is-invalid': validasi.nama_irban }">
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
            alert: {
                error: false,
                update: false,
                validate: false
            },
            validasi: {
                nama_irban: ''
            },
            isLoading: false,
        }
    },
    props: ['api','irban','route'],
    methods: {
        clearAlert() {
            this.alert.error = false;
            this.alert.update = false;
            this.alert.validate = false;
        },
        onSubmit(evt) {
            evt.preventDefault();
            this.clearAlert();
            let validasi = this.validate();
            if (validasi === true) {
                this.isLoading = true;
                service.putData(this.api, this.irban)
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
                this.alert.update = true;
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                setTimeout(() => this.alert.update = false, 5000);
            }
        },
        validate() {
            let condition = 0;

            if (this.irban.nama_irban.length === 0) {
                this.validasi.nama_irban = true;
                condition++;
            } else {
                this.validasi.nama_irban = false;
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
