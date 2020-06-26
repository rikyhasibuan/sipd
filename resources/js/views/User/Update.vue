<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <transition name="fade">
                        <v-alert :alert=alert></v-alert>
                    </transition>
                    <loading :opacity="100" :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" @submit.prevent="onSubmit()">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Pegawai *</label>
                                <select v-model="user.nip" :class="{ 'is-invalid': validasi.nip }" class="form-control">
                                    <option value="">Pilih Pegawai</option>
                                    <option v-for="v in this.pegawai_data" :value="v.nip" :key="v.id">
                                        {{ v.nama }} - {{ v.jabatan }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Level *</label>
                                <select v-model="user.level_id" :class="{ 'is-invalid': validasi.level_id }" class="form-control">
                                    <option value="">Pilih Level</option>
                                    <option v-for="v in this.level_data" :value="v.id" :key="v.id">{{ v.nama_level }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Status *</label>
                                <select v-model="user.status" :class="{ 'is-invalid': validasi.status }" class="form-control">
                                    <option value="">Pilih Status</option>
                                    <option v-for="(v,k) in this.status" :value="k" :key="k">{{ v }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                <button type="button" class="btn btn-warning" @click.prevent="resetPassword()"><i class="fa fa-refresh"></i> Reset Password</button>
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
                    reset:false,
                    validate: false
                },
                status: {
                    1:'Aktif',
                    0:'Non-Aktif'
                },
                isLoading: false,
                validasi: {
                    'nip': '',
                    'level_id': '',
                    'status': ''
                }
            }
        },
        props: ['level_data', 'pegawai_data', 'user', 'api', 'route','reset_password'],
        methods: {
            clearAlert() {
                this.alert.error = false;
                this.alert.update = false;
                this.alert.reset = false;
                this.alert.validate = false;
            },
            onSubmit(evt) {
                evt.preventDefault();
                this.clearAlert();
                let validasi = this.validate();
                if (validasi === true) {
                    this.isLoading = true;
                    service.putData(this.api, this.user)
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
                setTimeout(() => { this.isLoading = false }, 1000);
                if (result.status === 'ok') {
                    this.alert.update = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(() => this.alert.update = false, 5000);
                }
            },
            validate() {
                let condition = 0;

                if (this.user.nip.length === 0) {
                    this.validasi.nip = true;
                    condition++;
                } else {
                    this.validasi.nip = false;
                }

                if (this.user.level_id.length === 0) {
                    this.validasi.level_id = true;
                    condition++;
                } else {
                    this.validasi.level_id = false;
                }

                if (this.user.status.length === 0) {
                    this.validasi.status = true;
                    condition++;
                } else {
                    this.validasi.status = false;
                }

                if (condition > 0) {
                    return false;
                } else {
                    return true;
                }
            },
            resetPassword() {
                service.putData(this.reset_password)
                .then(result => {
                    setTimeout(() => { this.isLoading = false }, 1000);
                    if (result.status === 'ok') {
                        this.alert.reset = true;
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                        setTimeout(() => this.alert.reset = false, 5000);
                    }
                }).catch(error => {
                    this.isLoading = false;
                    this.alert.error = true;
                    window.scroll({top: 0, left: 0, behavior: 'smooth'});
                    console.log(error);
                });
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
