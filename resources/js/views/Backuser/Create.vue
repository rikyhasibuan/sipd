<template>
    <vcl-table v-if="placeholder === true"></vcl-table>
    <div v-else>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <v-alert :errorAlert=errorAlert :duplicateAlert=duplicateAlert :saveAlert=saveAlert></v-alert>
                        <form method="POST" v-on:submit.prevent="onSubmit">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username">Username *</label>
                                    <input type="text" class="form-control" v-model="user.username" placeholder="Username" required="required">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username">Nama *</label>
                                    <input type="text" class="form-control" v-model="user.nama" placeholder="Nama" required="required">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Level *</label>
                                    <select v-model="user.level" class="form-control" required="required">
                                        <option value="">Pilih Level</option>
                                        <option value="2">Operator</option>
                                        <option value="3">Manajemen</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Status *</label>
                                    <select v-model="user.status" class="form-control" required="required">
                                        <option value="">Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                    <a :href="route" class="btn btn-flat btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
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
import service from './../../../services.js';
import { VclTable } from 'vue-content-loading';
import Alert from './../../Components/Alert';

export default {
    data() {
        return {
            user: {
                'username':'',
                'nama':'',
                'level':'',
                'status':''
            },
            errorAlert:false,
            saveAlert:false,
            duplicateAlert:false,
            placeholder:false
        }
    },
    props: ['api','route'],
    components: {
        VclTable,
        'v-alert':Alert
    },
    methods: {
        onSubmit (evt) {
            this.$Progress.start();
            service.postData(this.api, this.user)
            .then(result => {
                this.response(result);
                this.$Progress.finish();
            }).catch(error => {
                this.$Progress.finish();
                this.errorAlert = true;
                this.saveAlert = false;
                this.duplicateAlert = false;
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
        },
        response(result) {
            if (result.status === 'OK') {
                this.errorAlert = false;
                this.duplicateAlert = false;
                this.saveAlert = true;
                window.scroll({ top: 0, left: 0, behavior: 'smooth' })
                this.reset();
                setTimeout(() => this.saveAlert=false, 5000);
            } else if (result.status === 'DUPLICATE') {
                this.duplicateAlert = true;
                this.errorAlert = false;
                this.saveAlert = false;
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
            }
        },
        reset() {
            this.user.username = '';
            this.user.nama = '';
            this.user.level = '';
            this.user.status = '';
        }
    },
    created() {
        this.placeholder = true;
        this.$Progress.start();
    },
    mounted() {
        this.placeholder = false;
        this.$Progress.finish();
    }
};
</script>