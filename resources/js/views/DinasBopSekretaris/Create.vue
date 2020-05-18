<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <v-alert :alert=alert></v-alert>
                        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                        <form method="POST" v-on:submit.prevent="onSubmit" enctype="multipart/form-data">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Nomor Surat Perintah *</label>
                                        <input type="text" class="form-control" v-model="dinasbopsekretaris.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Surat Perintah *</label>
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

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Mulai *</label>
                                        <date-picker
                                            id="dari"
                                            name="dari"
                                            v-model="dinasbopsekretaris.dari"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Mulai" autocomplete="off">
                                        </date-picker>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Selesai *</label>
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
    </div>
</template>

<script>
    import service from './../../services.js';

    export default {
        data() {
            return {
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    locale: 'id',
                    maxDate: moment(this.dinasbop_data.sampai).add(1, 'day'),
                    disabledDates: [
                        moment(this.dinasbop_data.sampai).add(1, 'day')
                    ]
                },
                dinasbopsekretaris: {
                    'nomor_sp': '',
                    'tgl_sp': '',
                    'dari': '',
                    'sampai': '',
                    'dasar': [],
                    'tujuan': []
                },
                form:'',
                alert: {
                    error: false,
                    save: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: [
            'dinasbop',
            'dinasbop_data',
            'api',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                this.isLoading = true;
                service.postData(this.api + '/sekretaris/' + this.dinasbop, this.dinasbopsekretaris)
                .then(result => {
                    this.response(result);
                }).catch(error => {
                    this.isLoading = false;
                    this.alert.error = true;
                    this.alert.duplicate = false;
                    this.alert.save = false;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    console.log(error);
                });
            },
            response(result) {
                this.isLoading = false;
                if (result.status === 'ok') {
                    this.alert.error = false;
                    this.alert.duplicate = false;
                    this.alert.save = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    this.reset();
                    setTimeout(() => this.alert.save = false, 2000);
                } else if (result.status === 'duplicate') {
                    this.alert.duplicate = true;
                    this.alert.error = false;
                    this.alert.save = false;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                }
            },
            reset() {
                this.dinasbopsekretaris.nomor_sp = '';
                this.dinasbopsekretaris.tgl_sp = '';
                this.dinasbopsekretaris.dari = '';
                this.dinasbopsekretaris.sampai = '';
                this.dinasbopsekretaris.dasar = [];
                this.dinasbopsekretaris.tujuan = [];
            }
        },
        created() {
            this.$cookies.set("last_tab", "sekretaris");
            this.isLoading = true;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
