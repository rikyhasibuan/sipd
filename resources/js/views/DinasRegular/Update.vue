<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="bidang">Program *</label>
                                <select v-model="dinasregular.program_id" class="form-control" required="required">
                                    <option value="">Pilih Program</option>
                                    <option v-for="v in this.program_data" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_program }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="bidang">Kegiatan *</label>
                                <select v-model="dinasregular.kegiatan_id" class="form-control" required="required">
                                    <option value="">Pilih Kegiatan</option>
                                    <option v-for="v in this.kegiatan_data" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_kegiatan }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="bidang">Belanja *</label>
                                <select v-model="dinasregular.belanja_id" class="form-control" required="required">
                                    <option value="">Pilih Belanja</option>
                                    <option v-for="v in this.belanja_data" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_belanja }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nama">Dasar *</label>
                                <textarea class="form-control" v-model="dinasregular.dasar" required="required" rows="3"></textarea>
                                <br>
                                <textarea class="form-control" v-model="dinasregular.dasar" rows="3"></textarea>
                                <br>
                                <textarea class="form-control" v-model="dinasregular.dasar" rows="3"></textarea>
                                <br>
                                <textarea class="form-control" v-model="dinasregular.dasar" rows="3"></textarea>
                                <br>
                                <textarea class="form-control" v-model="dinasregular.dasar" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nama">Peruntukan *</label>
                                <textarea class="form-control" v-model="dinasregular.untuk" required="required" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nama">Tanggal Mulai *</label>
                                <input type="date" class="form-control" v-model="dinasregular.mulai" required="required">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nama">Tanggal Selesai *</label>
                                <input type="date" class="form-control" v-model="dinasregular.selesai" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="bidang">Irban *</label>
                                <select v-model="dinasregular.irban" class="form-control" required="required">
                                    <option value="">Pilih Irban</option>
                                    <option v-for="(k,v) in this.tujuan_data" v-bind:value="v" v-bind:key="v">{{ v }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="bidang">Tujuan *</label>
                                <select v-model="dinasregular.tujuan" class="form-control" required="required">
                                    <option value="">Pilih Tujuan</option>
                                    <option v-for="(k,v) in this.tujuan_data" v-bind:value="v" v-bind:key="v">{{ v }}</option>
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
        props: ['program_data','kegiatan_data','belanja_data','bulan_data','tahun_data','anggaran', 'api', 'route'],
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
                if (result.status === 'OK') {
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
