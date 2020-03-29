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
                                <label for="bidang">Program *</label>
                                <select v-model="kegiatan.program_id" class="form-control" required="required">
                                    <option value="">Pilih Program</option>
                                    <option v-for="v in this.program_data" v-bind:value="v.id" v-bind:key="v.id">
                                        {{ v.nama_program }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="bidang">Bendahara *</label>
                                <select v-model="kegiatan.bendahara" class="form-control" required="required">
                                    <option value="">Pilih Bendahara</option>
                                    <option v-for="v in this.bendahara_data" v-bind:value="v.id" v-bind:key="v.id">
                                        {{ v.nama }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nip">Kode Kegiatan *</label>
                                <input type="text" class="form-control" v-model="kegiatan.kode_kegiatan" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nama">Nama Kegiatan *</label>
                                <input type="text" class="form-control" v-model="kegiatan.nama_kegiatan" required="required">
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
        props: ['program_data','bendahara_data', 'api', 'route', 'kegiatan'],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api, this.kegiatan)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.isLoading = false;
                        this.alert.error = true;
                        window.scroll({
                            top: 0,
                            left: 0,
                            behavior: 'smooth'
                        });
                        console.log(error);
                    });
            },
            response(result) {
                if (result.status === 'ok') {
                    this.alert.error = false;
                    this.alert.update = true;
                    window.scroll({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    });
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
        }
    };
</script>
