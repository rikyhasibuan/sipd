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
                                <label>Kabupaten / Kota *</label>
                                <select v-model="akomodasi.kabkota_id" class="form-control" :class="{ 'is-invalid': validasi.kabkota_id }">
                                    <option value="">Pilih Kabupaten / Kota</option>
                                    <option v-for="v in this.kabkota_data" v-bind:value="v.id" v-bind:key="v.id">
                                        {{ v.nama_kabkota }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Eselon II *</label>
                                <input type="text" class="form-control" v-model="akomodasi.eselon_2" :class="{ 'is-invalid': validasi.eselon_2 }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Eselon III *</label>
                                <input type="text" class="form-control" v-model="akomodasi.eselon_3" :class="{ 'is-invalid': validasi.eselon_3 }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Fungsional Madya *</label>
                                <input type="text" class="form-control" v-model="akomodasi.madya" :class="{ 'is-invalid': validasi.madya }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Eselon IV, Gol. IV dan Gol. III *</label>
                                <input type="text" class="form-control" v-model="akomodasi.eselon_4_gol_3_4" :class="{ 'is-invalid': validasi.eselon_4_gol_3_4 }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Gol. II dan Gol. I *</label>
                                <input type="text" class="form-control" v-model="akomodasi.gol_1_2" :class="{ 'is-invalid': validasi.gol_1_2 }">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
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
                    validate: false
                },
                validasi: {
                    kabkota_id: '',
                    eselon_2: '',
                    eselon_3: '',
                    madya: '',
                    eselon_4_gol_3_4: '',
                    gol_1_2: ''
                },
                isLoading: false,
            }
        },
        props: ['kabkota_data', 'api', 'route', 'akomodasi'],
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                this.alert.error = false;
                this.alert.update = false;
                let validasi = this.validate();
                if (validasi === true) {
                    service.putData(this.api, this.akomodasi)
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
                    setTimeout(() => this.alert.validate = false, 2000);
                }
            },
            response(result) {
                setTimeout(() => { this.isLoading = false }, 1000);
                if (result.status === 'ok') {
                    this.alert.error = false;
                    this.alert.update = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    setTimeout(() => this.alert.update = false, 5000);
                }
            },
            validate() {
                let condition = 0;

                if (this.akomodasi.kabkota_id.length === 0) {
                    this.validasi.kabkota_id = true;
                    condition++;
                } else {
                    this.validasi.kabkota_id = false;
                }

                if (this.akomodasi.eselon_2.length === 0) {
                    this.validasi.eselon_2 = true;
                    condition++;
                } else {
                    this.validasi.eselon_2 = false;
                }

                if (this.akomodasi.eselon_3.length === 0) {
                    this.validasi.eselon_3 = true;
                    condition++;
                } else {
                    this.validasi.eselon_3 = false;
                }

                if (this.akomodasi.madya.length === 0) {
                    this.validasi.madya = true;
                    condition++;
                } else {
                    this.validasi.madya = false;
                }

                if (this.akomodasi.eselon_4_gol_3_4.length === 0) {
                    this.validasi.eselon_4_gol_3_4 = true;
                    condition++;
                } else {
                    this.validasi.eselon_4_gol_3_4 = false;
                }

                if (this.akomodasi.gol_1_2.length === 0) {
                    this.validasi.gol_1_2 = true;
                    condition++;
                } else {
                    this.validasi.gol_1_2 = false;
                }

                if (condition > 0) {
                    return false;
                } else {
                    return true;
                }
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
