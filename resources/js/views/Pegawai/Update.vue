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
                                <select v-model="pegawai.pangkat" @change="onChangePangkat($event)" class="form-control" required="required">
                                    <option value="">Pilih Pangkat</option>
                                    <option v-for="v in this.pangkat_data" v-bind:value="v.nama_pangkat" v-bind:key="v.id">{{ v.nama_pangkat }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Jabatan *</label>
                                <select v-model="pegawai.jabatan" class="form-control" required="required">
                                    <option value="">Pilih Jabatan</option>
                                    <option v-for="v in this.jabatan_data" v-bind:value="v.nama_jabatan" v-bind:key="v.id">{{ v.nama_jabatan }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Eselon</label>
                                <select v-model="pegawai.eselon" class="form-control">
                                    <option value="">Pilih Eselon</option>
                                    <option v-for="(k,v) in this.eselon_data" v-bind:value="k" v-bind:key="k">{{ v }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
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
                isLoading: false,
            }
        },
        props: ['golongan_data', 'pangkat_data', 'jabatan_data','eselon_data', 'api', 'route', 'pegawai'],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api, this.pegawai)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.isLoading = false;
                        this.alert.error = true;
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                        console.log(error);
                    });
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
            if (this.pegawai.eselon === null) {
                this.pegawai.eselon = '';
            } 
        }
    };
</script>
