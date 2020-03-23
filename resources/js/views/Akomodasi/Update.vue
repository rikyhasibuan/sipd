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
                                <label for="bidang">Kabupaten / Kota *</label>
                                <select v-model="akomodasi.kabkota_id" class="form-control" required="required">
                                    <option value="">Pilih Kabupaten / Kota</option>
                                    <option v-for="v in this.kabkota_data" v-bind:value="v.id" v-bind:key="v.id">
                                        {{ v.nama_kabkota }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nip">Eselon II *</label>
                                <input type="text" class="form-control" v-model="akomodasi.eselon_2" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nip">Eselon III *</label>
                                <input type="text" class="form-control" v-model="akomodasi.eselon_3" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nip">Fungsional Madya *</label>
                                <input type="text" class="form-control" v-model="akomodasi.madya" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nip">Eselon IV, Gol. IV dan Gol. III *</label>
                                <input type="text" class="form-control" v-model="akomodasi.eselon_4_gol_3_4" required="required">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nip">Gol. II dan Gol. I *</label>
                                <input type="text" class="form-control" v-model="akomodasi.gol_1_2" required="required">
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
        props: ['kabkota_data', 'api', 'route', 'akomodasi'],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api, this.akomodasi)
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