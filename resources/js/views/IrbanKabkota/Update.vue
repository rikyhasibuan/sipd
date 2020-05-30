<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Irban</label>
                                <select v-model="irbankabkota.irban_id" class="form-control mb-2 mr-sm-2" required="required">
                                    <option value="">Pilih Irban</option>
                                    <option v-for="v in this.irban_data" :value="v.id" :key="v.id">{{ v.nama_irban }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Kabupaten / Kota</label>
                                <select v-model="irbankabkota.kabkota_id" class="form-control mb-2 mr-sm-2" required="required">
                                    <option value="">Pilih Kabupaten / Kota</option>
                                    <option v-for="v in this.kabkota_data" :value="v.id" :key="v.id">{{ v.nama_kabkota }}</option>
                                </select>
                            </div>

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
            isLoading: false
        }
    },
    props: ['api','kabkota_data','irban_data','irbankabkota','route'],
    methods: {
        onSubmit(evt) {
            this.isLoading = false;
            service.putData(this.api, this.irbankabkota)
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
    },
    mounted() {
        this.isLoading = false;
    }
};
</script>
