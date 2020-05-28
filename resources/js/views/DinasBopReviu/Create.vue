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
                                        <input type="text" class="form-control" v-model="dinasbopreviu.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
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
                                                v-model="dinasbopreviu.tgl_sp"
                                                :config="options"
                                                class="form-control"
                                                placeholder="Tanggal Surat Perintah" autocomplete="off">
                                            </date-picker>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Dasar *</label>
                                        <input type="text" class="form-control" placeholder="Dasar 1" v-model="dinasbopreviu.dasar[0]" required="required">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Dasar 2" v-model="dinasbopreviu.dasar[1]">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Dasar 3" v-model="dinasbopreviu.dasar[2]">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tujuan *</label>
                                        <input type="text" class="form-control" placeholder="Tujuan 1" v-model="dinasbopreviu.tujuan[0]" required="required">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Tujuan 2" v-model="dinasbopreviu.tujuan[1]">
                                        <br>
                                        <input type="text" class="form-control" placeholder="Tujuan 3" v-model="dinasbopreviu.tujuan[2]">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Tanggal Mulai *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <date-picker
                                                id="dari"
                                                name="dari"
                                                v-model="dinasbopreviu.dari"
                                                :config="options"
                                                class="form-control"
                                                placeholder="Tanggal Mulai" autocomplete="off">
                                            </date-picker>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Tanggal Selesai *</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <date-picker
                                                id="sampai"
                                                name="sampai"
                                                v-model="dinasbopreviu.sampai"
                                                :config="options"
                                                class="form-control"
                                                placeholder="Tanggal Selesai" autocomplete="off">
                                            </date-picker>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Ketua Tim *</label>
                                        <select v-model="dinasbopreviu.ketuatim" class="form-control" required="required">
                                            <option value="">Pilih Ketua Tim</option>
                                            <option v-for="v in ketua" :key="v.id" :value="v.nip">
                                                {{ v.nama }} - {{ v.jabatan }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Anggota *</label>
                                        <multiselect
                                            :multiple="true"
                                            :taggable="true"
                                            placeholder="Pilih Anggota"
                                            v-model="dinasbopreviu.anggota"
                                            :options="anggota_data"
                                            track-by="key"
                                            label="label"
                                            :allow-empty="true"
                                        >
                                        </multiselect>
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
                    locale:'id',
                    minDate: moment(this.dinasbop_data.dari),
                    maxDate: moment(this.dinasbop_data.sampai).add(1, 'day'),
                    disabledDates: [
                        moment(this.dinasbop_data.sampai).add(1, 'day')
                    ]
                },
                dinasbopreviu: {
                    'nomor_sp': '',
                    'tgl_sp': '',
                    'dasar':[],
                    'tujuan':[],
                    'dari': '',
                    'sampai': '',
                    'ketuatim':'',
                    'anggota':[]
                },
                anggota_data:[],
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
            'anggota',
            'ketua',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                service.postData(this.api + '/reviu/' + this.dinasbop, this.dinasbopreviu)
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
                this.dinasbopreviu.dasar = [];
                this.dinasbopreviu.tujuan = [];
                this.dinasbopreviu.nomor_sp = '';
                this.dinasbopreviu.tgl_sp = '';
                this.dinasbopreviu.dari = '';
                this.dinasbopreviu.sampai = '';
                this.dinasbopreviu.ketuatim = '';
                this.dinasbopreviu.anggota = [];
            }
        },
        created() {
            this.$cookies.set("last_tab", "reviu");
            this.isLoading = true;
            this.anggota.forEach(item => {
                this.anggota_data.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
