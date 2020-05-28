<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit" enctype="multipart/form-data" autocomplete="off">
                        <div class="col-md-12 col-sm-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nomor Surat Perintah *</label>
                                    <input type="text" class="form-control" v-model="dinasbopsekretaris.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Surat Perintah *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <date-picker
                                            id="tgl_sp"
                                            name="tgl_sp"
                                            v-model="dinasbopsekretaris.tgl_sp"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Surat Perintah" autocomplete="off">
                                        </date-picker>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Tanggal Mulai *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <date-picker
                                            id="dari"
                                            name="dari"
                                            v-model="dinasbopsekretaris.dari"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Mulai" autocomplete="off">
                                        </date-picker>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Selesai *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <date-picker
                                            id="sampai"
                                            name="sampai"
                                            v-model="dinasbopsekretaris.sampai"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Selesai" autocomplete="off">
                                        </date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Dasar *</label>
                                    <input type="text" class="form-control" placeholder="Dasar 1" v-model="dinasbopsekretaris.dasar[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 2" v-model="dinasbopsekretaris.dasar[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 3" v-model="dinasbopsekretaris.dasar[2]">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tujuan *</label>
                                    <input type="text" class="form-control" placeholder="Tujuan 1" v-model="dinasbopsekretaris.tujuan[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 2" v-model="dinasbopsekretaris.tujuan[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 3" v-model="dinasbopsekretaris.tujuan[2]">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Data</button>
                                    <a :href="route" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                                </div>
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
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    locale: 'id',
                    minDate: moment(this.dinasbop_data.dari),
                    maxDate: moment(this.dinasbop_data.sampai).add(1, 'day'),
                    disabledDates: [
                        moment(this.dinasbop_data.sampai).add(1, 'day')
                    ]
                },
                isLoading: false
            }
        },
        props: [
            'sekretaris_data',
            'dinasbop',
            'dinasbop_data',
            'dinasbopsekretaris',
            'api',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api + '/sekretaris/' + this.dinasbop + '/' + this.dinasbopsekretaris.id, this.dinasbopsekretaris)
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
            this.$cookies.set("last_tab", "sekretaris");
            this.isLoading = true;
        },
        mounted() {
            this.isLoading = false;
            this.dinasbopsekretaris.sekretaris = this.dinasbopsekretaris.sekretaris.nip
        }
    };
</script>
