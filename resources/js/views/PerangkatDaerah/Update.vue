<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <v-alert :alert=alert></v-alert>
                        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                        <form method="POST" v-on:submit.prevent="onSubmit">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama Perangkat Daerah</label>
                                    <input type="text" class="form-control" id="nama_skpd" v-model="perangkatdaerah.nama_skpd"  placeholder="Nama Perangkat Daerah" required="required">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kontak</label>
                                    <input type="text" class="form-control" id="kontak" v-model="perangkatdaerah.kontak"  placeholder="Nomor Telepon" required="required">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Alamat</label>
                                    <textarea class="form-control" id="alamat" v-model="perangkatdaerah.alamat"  required="required"></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Kota</label>
                                    <select v-model="perangkatdaerah.kota" class="form-control" required="required">
                                        <option value="">Pilih Kota</option>
                                        <option v-for="v in this.kabkota" :value="v.nama_kabkota" :key="v.id">
                                            {{ v.nama_kabkota }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
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
            isLoading: false
        }
    },
    props: ['api','perangkatdaerah','kabkota','route'],
    methods: {
        onSubmit(evt) {
            this.isLoading = true;
            service.putData(this.api, this.perangkatdaerah)
                .then(result => {
                    this.isLoading = false;
                    this.response(result);
                }).catch(error => {
                    this.isLoading = false;
                    this.alert.error = true;
                    this.alert.update = false;
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
                })
                setTimeout(() => this.alert.update = false, 5000);
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