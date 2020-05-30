<template>
    <div>
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
                                        <input type="text" class="form-control" v-model="dinasbopinspektur.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
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
                                                v-model="dinasbopinspektur.tgl_sp"
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
                                                v-model="dinasbopinspektur.dari"
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
                                                v-model="dinasbopinspektur.sampai"
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
                                        <input type="text" class="form-control" placeholder="Dasar 1" v-model="dinasbopinspektur.dasar[0]" required="required">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Dasar 2" v-model="dinasbopinspektur.dasar[1]">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Dasar 3" v-model="dinasbopinspektur.dasar[2]">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tujuan *</label>
                                        <input type="text" class="form-control" placeholder="Tujuan 1" v-model="dinasbopinspektur.tujuan[0]" required="required">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Tujuan 2" v-model="dinasbopinspektur.tujuan[1]">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Tujuan 3" v-model="dinasbopinspektur.tujuan[2]">
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
                    minDate: this.dinasbop_data.dari,
                    maxDate: moment(this.dinasbop_data.sampai).add(1, 'day'),
                    disabledDates: [
                        moment(this.dinasbop_data.sampai).add(1, 'day')
                    ]
                },
                dinasbopinspektur: {
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
                isLoading: false,
                usernip:''
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
                service.postData(this.api + '/inspektur?nip='+this.usernip+'&dinasbop='+this.dinasbop, this.dinasbopinspektur)
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
                this.dinasbopinspektur.nomor_sp = '';
                this.dinasbopinspektur.tgl_sp = '';
                this.dinasbopinspektur.dari = '';
                this.dinasbopinspektur.sampai = '';
                this.dinasbopinspektur.dasar = [];
                this.dinasbopinspektur.tujuan = [];
            }
        },
        created() {
            this.$cookies.set("last_tab", "inspektur");
            this.isLoading = true;
        },
        mounted() {
            this.isLoading = false;
            this.usernip = this.$cookies.get('nip');
        }
    };
</script>
