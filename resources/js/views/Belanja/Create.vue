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
                belanja: {
                    'program_id': '',
                    'kegiatan_id': '',
                    'kode_belanja': '',
                    'nama_belanja': ''
                },
                program:[],
                kegiatan:[],
                alert: {
                    error: false,
                    save: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: ['program_data','kegiatan_data', 'api', 'route'],
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                this.isLoading = true;
                service.postData(this.api, this.belanja)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.alert.error = true;
                        this.alert.duplicate = false;
                        this.alert.save = true;
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
                setTimeout(() => { this.isLoading = false }, 1000);
                if (result.status === 'ok') {
                    this.alert.error = false;
                    this.alert.duplicate = false;
                    this.alert.save = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    this.reset();
                    setTimeout(() => this.alert.save = false, 5000);
                } else if (result.status === 'duplicate') {
                    this.alert.duplicate = true;
                    this.alert.error = false;
                    this.alert.save = false;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                }
            },
            reset() {
                this.belanja.program_id = '';
                this.belanja.kegiatan_id = '';
                this.belanja.kode_belanja = '';
                this.belanja.nama_belanja = '';
                this.kegiatan = [];
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