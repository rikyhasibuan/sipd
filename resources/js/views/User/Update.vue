<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Pegawai *</label>
                                <select v-model="user.nip" class="form-control" required="required">
                                    <option value="">Pilih Pegawai</option>
                                    <option v-for="v in this.pegawai_data" :value="v.nip" :key="v.id">
                                        {{ v.nama }} - {{ v.jabatan }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Level *</label>
                                <select v-model="user.level_id" class="form-control" required="required">
                                    <option value="">Pilih Level</option>
                                    <option v-for="v in this.level_data" :value="v.id" :key="v.id">{{ v.nama_level }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Status *</label>
                                <select v-model="user.status" class="form-control" required="required">
                                    <option value="">Pilih Status</option>
                                    <option v-for="(v,k) in this.status" :value="k" :key="k">{{ v }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>Simpan Data</button>
                                <a :href="route" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
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
                    update: false
                },
                status: {
                    1:'Aktif',
                    0:'Non-Aktif'
                },
                isLoading: false,
            }
        },
        props: ['level_data', 'pegawai_data', 'user', 'api', 'route'],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api, this.user)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.isLoading = false;
                        this.alert.error = true;
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                        console.log(error);
                    });
            },
            response(result) {
                if (result.status === 'ok') {
                    this.alert.error = false;
                    this.alert.update = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(() => this.alert.update = false, 5000);
                }
                this.isLoading = false;
            }
        },
        created() {
            this.isLoading = true;
        },
        mounted() {
            this.isLoading = false;
            console.log(this.user.status);
        }
    };
</script>
