<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <v-alert :alert=alert></v-alert>
                        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                        <form autocomplete="off" method="POST" v-on:submit.prevent="onSubmit">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Dasar Surat Perintah *</label>
                                    <input type="text" class="form-control" placeholder="Dasar 1" v-model="dinasboppengumpuldata.dasar[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 2" v-model="dinasboppengumpuldata.dasar[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 3" v-model="dinasboppengumpuldata.dasar[2]">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Tujuan Pemeriksaan *</label>
                                    <input type="text" class="form-control" placeholder="Tujuan 1" v-model="dinasboppengumpuldata.untuk[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 2" v-model="dinasboppengumpuldata.untuk[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 3" v-model="dinasboppengumpuldata.untuk[2]">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Tanggal Mulai *</label>
                                    <date-picker
                                        id="dari"
                                        name="dari"
                                        v-model="dinasboppengumpuldata.dari"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Mulai"
                                        required="required"
                                        autocomplete="off">
                                    </date-picker>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Selesai *</label>
                                    <date-picker
                                        id="sampai"
                                        name="sampai"
                                        v-model="dinasboppengumpuldata.sampai"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Selesai"
                                        required="required"
                                        autocomplete="off">
                                    </date-picker>
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
    </div>
</template>

<script>
    import service from './../../services.js';

    export default {
        data() {
            return {
                dinasboppengumpuldata: {
                    'dasar': [],
                    'untuk': [],
                    'dari': '',
                    'sampai': ''
                },
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    locale: 'id',
                    minDate: this.dinasbop.dari,
                    maxDate: moment(this.dinasbop.sampai).add(1, 'day'),
                    disabledDates: [
                        moment(this.dinasbop.sampai).add(1, 'day')
                    ]
                },
                alert: {
                    error: false,
                    save: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: [
            'api',
            'dinasbop',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                service.postData(this.api, this.dinasboppengumpuldata)
                .then(result => {
                    this.response(result);
                }).catch(error => {
                    this.isLoading = false;
                    this.alert.error = false;
                    this.alert.duplicate = false;
                    this.alert.save = false;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    console.log(error);
                });

            },
            response(result) {
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
                this.dinasboppengumpuldata.dasar = [];
                this.dinasboppengumpuldata.untuk = [];
                this.dinasboppengumpuldata.dari = '';
                this.dinasboppengumpuldata.sampai = '';
            }
        },
        created() {
            this.$cookies.set("last_tab", "pengumpuldata");
            this.isLoading = true;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
