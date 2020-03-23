<template>
    <div>
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
    </div>
</template>

<script>
    import service from './../../services.js';

    export default {
        data() {
            return {
                kegiatan: {
                    'program_id': '',
                    'bendahara': '',
                    'kode_kegiatan': '',
                    'nama_kegiatan': ''
                },
                alert: {
                    error: false,
                    save: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: ['bendahara_data','program_data', 'api', 'route'],
        methods: {
            onSubmit(evt) {
                service.postData(this.api, this.kegiatan)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.$Progress.finish();
                        this.errorAlert = true;
                        this.saveAlert = false;
                        this.duplicateAlert = false;
                        window.scroll({
                            top: 0,
                            left: 0,
                            behavior: 'smooth'
                        });
                        console.log(error);
                    });
            },
            response(result) {
                if (result.status === 'OK') {
                    this.alert.error = false;
                    this.alert.duplicate = false;
                    this.alert.save = true;
                    window.scroll({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    })
                    this.reset();
                    setTimeout(() => this.alert.save = false, 5000);
                } else if (result.status === 'DUPLICATE') {
                    this.alert.duplicate = true;
                    this.alert.error = false;
                    this.alert.save = false;
                    window.scroll({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    });
                }
            },
            reset() {
                this.kegiatan.program_id = '';
                this.kegiatan.bendahara = '';
                this.kegiatan.kode_kegiatan = '';
                this.kegiatan.nama_kegiatan = '';
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