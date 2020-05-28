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
                                    <input type="text" class="form-control" v-model="reviu.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
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
                                            v-model="reviu.tgl_sp"
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
                                    <input type="text" class="form-control" placeholder="Dasar 1" v-model="reviu.dasar[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 2" v-model="reviu.dasar[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 3" v-model="reviu.dasar[2]">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tujuan *</label>
                                    <input type="text" class="form-control" placeholder="Tujuan 1" v-model="reviu.tujuan[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 2" v-model="reviu.tujuan[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 3" v-model="reviu.tujuan[2]">
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
                                            v-model="reviu.dari"
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
                                            v-model="reviu.sampai"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Selesai" autocomplete="off">
                                        </date-picker>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Ketua Tim *</label>
                                    <select v-model="reviu.ketuatim" class="form-control" required="required">
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
                                        v-model="reviu.anggota"
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
                    format : 'YYYY-MM-DD',
                    useCurrent : false,
                    locale : 'id',
                    minDate: moment(this.dinasbop_data.dari),
                    maxDate: moment(this.dinasbop_data.sampai).add(1, 'day'),
                    disabledDates: [
                        moment(this.dinasbop_data.sampai).add(1, 'day')
                    ]
                },
                reviu: {
                    'nomor_sp' : '',
                    'tgl_sp' : '',
                    'dasar' : [],
                    'tujuan' : [],
                    'dari' : '',
                    'sampai' : '',
                    'ketuatim' :'',
                    'anggota' : []
                },
                anggota_data:[],
            }
        },
        props: [
            'dinasbop',
            'dinasbopreviu',
            'dinasbop_data',
            'api',
            'anggota',
            'ketua',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api + '/reviu/' + this.dinasbop + '/' + this.dinasbopreviu.id, this.reviu)
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
            this.$cookies.set("last_tab", "reviu");
            this.isLoading = true;
            this.reviu.dinasbop_id = this.dinasbopreviu.dinasbop_id;
            this.reviu.nomor_sp = this.dinasbopreviu.nomor_sp;
            this.reviu.tgl_sp = this.dinasbopreviu.tgl_sp;
            this.reviu.dari = this.dinasbopreviu.dari;
            this.reviu.sampai = this.dinasbopreviu.sampai;
            this.reviu.dasar = this.dinasbopreviu.dasar;
            this.reviu.tujuan = this.dinasbopreviu.tujuan;

            this.reviu.ketuatim = this.dinasbopreviu.tim.ketuatim.nip;

            this.anggota.forEach(item => {
                this.anggota_data.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });

            let personil = this.dinasbopreviu.tim.anggota;

            personil.forEach(item => {
                this.reviu.anggota.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });

            this.isLoading = false;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
