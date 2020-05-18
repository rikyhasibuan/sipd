<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <transition name="fade">
                        <v-alert :alert=alert></v-alert>
                    </transition>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Kode Program *</label>
                                <input type="text" class="form-control" v-model="program.kode_program" :class="{ 'is-invalid': validasi.kode_program }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nama Program *</label>
                                <input type="text" class="form-control" v-model="program.nama_program" :class="{ 'is-invalid': validasi.nama_program }">
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
                alert: {
                    error: false,
                    update: false,
                    validate: false
                },
                validasi: {
                    'kode_program': '',
                    'nama_program': ''
                },
                isLoading: false,
            }
        },
        props: ['api', 'route', 'program'],
        methods: {
            onSubmit(evt) {
                this.alert.error = false;
                this.alert.update = false;
                this.alert.validate = false;
                let validasi = this.validate();
                if (validasi === true) {
                    this.isLoading = false;
                    service.putData(this.api, this.program)
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
                    setTimeout(() => this.alert.validate = false, 3000);
                }
            },
            response(result) {
                if (result.status === 'ok') {
                    this.alert.error = false;
                    this.alert.update = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(() => this.alert.update = false, 5000);
                }
                this.isLoading = false;
            },
            validate() {
                let condition = 0;

                if (this.program.kode_program.length === 0) {
                    this.validasi.kode_program = true;
                    condition++;
                } else {
                    this.validasi.kode_program = false;
                }

                if (this.program.nama_program.length === 0) {
                    this.validasi.nama_program = true;
                    condition++;
                } else {
                    this.validasi.nama_program = false;
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
