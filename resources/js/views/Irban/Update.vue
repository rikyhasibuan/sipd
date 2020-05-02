<template>
    <vcl-table v-if="placeholder === true"></vcl-table>
    <div v-else>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <v-alert :alert=alert></v-alert>
                        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                        <form method="POST" v-on:submit.prevent="onSubmit">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama Irban</label>
                                    <input type="text" class="form-control" v-model="irban.nama_irban" placeholder="Nama Irban">
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                    <a :href="route" class="btn btn-flat btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
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
            alert: {
                error: false,
                update: false
            },
            isLoading: false,
        }
    },
    props: ['api','irban','route'],
    methods: {
        onSubmit(evt) {
            this.isLoading = false;
            service.putData(this.api, this.irban)
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