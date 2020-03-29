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
                                    <select v-model="belanja.program_id" @change="onChangeProgram($event)" class="form-control" required="required">
                                        <option value="">Pilih Program</option>
                                        <option v-for="v in this.program" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_program }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Kegiatan *</label>
                                    <select v-model="belanja.kegiatan_id" class="form-control" required="required">
                                        <option value="">Pilih Kegiatan</option>
                                        <option v-for="v in this.kegiatan" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_kegiatan }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nip">Kode Belanja *</label>
                                    <input type="text" class="form-control" v-model="belanja.kode_belanja" required="required">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nama">Nama Belanja *</label>
                                    <input type="text" class="form-control" v-model="belanja.nama_belanja" required="required">
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
                program:[],
                kegiatan:[],
                alert: {
                    error: false,
                    update: false
                },
                isLoading: false
            }
        },
        props: ['program_data','kegiatan_data', 'belanja', 'api', 'route'],
        methods: {
            onSubmit(evt) {
                service.putData(this.api, this.belanja)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.$Progress.finish();
                        this.errorAlert = true;
                        this.saveAlert = false;
                        this.duplicateAlert = false;
                        window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                        console.log(error);
                    });
            },
            onChangeProgram(evt) {
                const program = evt.target.value;
                service.fetchData('../api/ajax/kegiatan/' + program)
                .then(response => {
                    this.belanja.kegiatan_id = '';
                    this.kegiatan = response;
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
            }
        },
        created() {
            this.isLoading = true;
            this.program = this.program_data;
            this.kegiatan = this.kegiatan_data;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>