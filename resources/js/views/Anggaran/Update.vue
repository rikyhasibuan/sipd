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
                                <label>Program *</label>
                                <select v-model="anggaran.program_id" class="form-control" required="required" @change="onChangeProgram($event)">
                                    <option value="">Pilih Program</option>
                                    <option v-for="v in this.program" :value="v.id" :key="v.id">{{ v.nama_program }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Kegiatan *</label>
                                <select v-model="anggaran.kegiatan_id" class="form-control" required="required" @change="onChangeKegiatan($event)">
                                    <option value="">Pilih Kegiatan</option>
                                    <option v-for="v in this.kegiatan" :value="v.id" :key="v.id">{{ v.nama_kegiatan }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Belanja *</label>
                                <select v-model="anggaran.belanja_id" class="form-control" required="required">
                                    <option value="">Pilih Belanja</option>
                                    <option v-for="v in this.belanja" :value="v.id" :key="v.id">{{ v.nama_belanja }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Jumlah Anggaran *</label>
                                <input type="text" class="form-control" v-model="anggaran.jumlah" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Bulan *</label>
                                <select v-model="anggaran.bulan" class="form-control" required="required">
                                    <option value="">Pilih Bulan</option>
                                    <option v-for="(v,k) in this.bulan_data" :value="k" :key="k">{{ v }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Tahun *</label>
                                <select v-model="anggaran.tahun" class="form-control" required="required">
                                    <option value="">Pilih Tahun</option>
                                    <option v-for="v in this.tahun_data" :value="v" :key="v">{{ v }}</option>
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
                program:'',
                kegiatan:'',
                belanja:'',
                isLoading: false,
            }
        },
        props: ['program_data','kegiatan_data','belanja_data','bulan_data','tahun_data','anggaran', 'api', 'route'],
        methods: {
            onChangeProgram(evt) {
                const program = evt.target.value;
                service.fetchData('../api/ajax/kegiatan/' + program)
                .then(response => {
                    this.anggaran.kegiatan_id = '';
                    this.anggaran.belanja_id = '';
                    this.kegiatan = response;
                    this.belanja = [];
                })
                .catch(error => {
                    console.log(error);
                });
            },
            onChangeKegiatan(evt) {
                const kegiatan = evt.target.value;
                service.fetchData('../api/ajax/belanja/' + kegiatan)
                .then(response => {
                    this.anggaran.belanja_id = '';
                    this.belanja = response;
                })
                .catch(error => {
                    console.log(error);
                });
            },
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api, this.kegiatan)
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
            this.kegiatan = this.kegiatan_data;
            this.belanja = this.belanja_data;

            service.fetchData('../api/ajax/kegiatan/' + this.anggaran.program_id)
            .then(response => {
                this.kegiatan = response;
            })
            .catch(error => {
                console.log(error);
            });

            service.fetchData('../api/ajax/belanja/' + this.anggaran.kegiatan_id)
            .then(response => {
                this.belanja = response;
            })
            .catch(error => {
                console.log(error);
            });
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
