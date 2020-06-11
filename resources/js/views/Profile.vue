<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <transition name="fade">
                        <v-alert :alert=alert></v-alert>
                    </transition>
                    <loading :opacity="100" :active.sync="isLoading" :can-cancel="false" :is-full-page="false"></loading>
                    <form method="POST" class="form-vertical" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Password Baru</label>
                                <input type="password" class="form-control" :class="{ 'is-invalid': validasi.password }" v-model="backuser.password" placeholder="Masukkan Password Baru">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Konfirmasi Password</label>
                                <input type="password" class="form-control" :class="{ 'is-invalid': validasi.repassword }" v-model="backuser.repassword" placeholder="Konfirmasi Password Baru">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import service from './../services.js';
    export default {
        data() {
            return {
                isLoading:false,
                alert: {
                    error:false,
                    update:false,
                    validate:false,
                    validatepassword:false
                },
                backuser: {
                    password:'',
                    repassword:'',
                    id : this.$cookies.get('id')
                },
                validasi: {
                    password:'',
                    repassword:''
                }
            }
        },
        props: ['api','user'],
        methods: {
            clearAlert() {
                this.alert.error = false;
                this.alert.update = false;
                this.alert.validate = false;
                this.alert.validatepassword = false;
            },
            formReset() {
                this.backuser.password = '';
                this.backuser.repassword = '';
            },
            onSubmit () {
                this.clearAlert();
                let validasi = this.validate();
                let validasi_password = this.validatePassword();

                if (validasi === true && validasi_password === true) {
                    this.isLoading = true;
                    service.putData(this.api, this.backuser)
                    .then(result => {
                        if (result.status === 'ok') {
                            this.alert.update = true;
                            this.formReset();
                            window.scroll({top: 0, left: 0, behavior: 'smooth'});
                            setTimeout(() => this.alert.update = false, 5000);
                        }
                    }).catch(error => {
                        this.alert.error = true;
                        window.scroll({top: 0, left: 0, behavior: 'smooth'});
                        console.log(error);
                    });
                } else if (validasi_password === false) {
                    this.alert.validatepassword = true;
                    setTimeout(() => this.alert.validatepassword = false, 3000);
                } else if (validasi === false) {
                    this.alert.validate = true;
                    setTimeout(() => this.alert.validate = false, 3000);
                }
                this.isLoading = false;
            },
            validatePassword() {
                if (this.backuser.password === this.backuser.repassword) {
                    this.validasi.password = false;
                    this.validasi.repassword = false;
                    return true;
                } else {
                    this.validasi.password = true;
                    this.validasi.repassword = true;
                    return false;
                }
            },
            validate() {
                let condition = 0;

                if (this.backuser.password.length === 0) {
                    this.validasi.password = true;
                    condition++;
                } else {
                    this.validasi.password = false;
                }

                if (this.backuser.repassword.length === 0) {
                    this.validasi.repassword = true;
                    condition++;
                } else {
                    this.validasi.repassword = false;
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
