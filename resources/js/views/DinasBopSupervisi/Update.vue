<template>
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
                                    <input type="text" class="form-control" v-model="supervisi.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Surat Perintah *</label>
                                    <date-picker
                                        id="tgl_sp"
                                        name="tgl_sp"
                                        v-model="supervisi.tgl_sp"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Surat Perintah" autocomplete="off">
                                    </date-picker>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Dasar *</label>
                                    <input type="text" class="form-control" placeholder="Dasar 1" v-model="supervisi.dasar[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 2" v-model="supervisi.dasar[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Dasar 3" v-model="supervisi.dasar[2]">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tujuan *</label>
                                    <input type="text" class="form-control" placeholder="Tujuan 1" v-model="supervisi.tujuan[0]" required="required">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 2" v-model="supervisi.tujuan[1]">
                                    <br>
                                    <input type="text" class="form-control" placeholder="Tujuan 3" v-model="supervisi.tujuan[2]">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Tanggal Mulai *</label>
                                    <date-picker
                                        id="dari"
                                        name="dari"
                                        v-model="supervisi.dari"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Mulai" autocomplete="off">
                                    </date-picker>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Tanggal Selesai *</label>
                                    <date-picker
                                        id="sampai"
                                        name="sampai"
                                        v-model="supervisi.sampai"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Selesai" autocomplete="off">
                                    </date-picker>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Ketua Tim *</label>
                                    <select v-model="supervisi.ketuatim" class="form-control" required="required">
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
                                        v-model="supervisi.anggota"
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
                    maxDate: moment(this.dinasbop_data.sampai).add(1, 'day'),
                    disabledDates: [
                        moment(this.dinasbop_data.sampai).add(1, 'day')
                    ]
                },
                supervisi: {
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
            'dinasbopsupervisi',
            'dinasbop_data',
            'api',
            'anggota',
            'ketua',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api + '/supervisi/' + this.dinasbop + '/' + this.dinasbopsupervisi.id, this.supervisi)
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
            this.$cookies.set("last_tab", "supervisi");
            this.isLoading = true;
            this.supervisi.dinasbop_id = this.dinasbopsupervisi.dinasbop_id;
            this.supervisi.nomor_sp = this.dinasbopsupervisi.nomor_sp;
            this.supervisi.tgl_sp = this.dinasbopsupervisi.tgl_sp;
            this.supervisi.dari = this.dinasbopsupervisi.dari;
            this.supervisi.sampai = this.dinasbopsupervisi.sampai;
            this.supervisi.dasar = this.dinasbopsupervisi.dasar;
            this.supervisi.tujuan = this.dinasbopsupervisi.tujuan;

            this.supervisi.ketuatim = this.dinasbopsupervisi.tim.ketuatim.nip;

            this.anggota.forEach(item => {
                this.anggota_data.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });

            let personil = this.dinasbopsupervisi.tim.anggota;

            personil.forEach(item => {
                this.supervisi.anggota.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });
            this.isLoading = false;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
