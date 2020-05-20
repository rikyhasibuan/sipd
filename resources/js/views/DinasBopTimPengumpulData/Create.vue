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
                                        <input type="text" class="form-control" v-model="dinasboptimpengumpuldata.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Surat Perintah *</label>
                                        <date-picker
                                            id="tgl_sp"
                                            name="tgl_sp"
                                            v-model="dinasboptimpengumpuldata.tgl_sp"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Surat Perintah" autocomplete="off">
                                        </date-picker>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Irban *</label>
                                        <select v-model="dinasboptimpengumpuldata.irban_id" @change="onChangeIrban($event)" class="form-control" required="required">
                                            <option value="">Pilih Irban</option>
                                            <option v-for="v in this.irban_data" :value="v.id" :key="v.id">{{ v.nama_irban }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Auditan *</label>
                                        <select v-model="dinasboptimpengumpuldata.auditan" class="form-control" required="required">
                                            <option value="">Pilih Auditan</option>
                                            <optgroup v-for="(k,v) in this.audit_data" :key="v" :label="v">
                                                <option v-for="val in k" :key="val" :value="val">{{ val }}</option>
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Ketua Tim *</label>
                                        <select v-model="dinasboptimpengumpuldata.ketuatim" class="form-control" required="required">
                                            <option value="">Pilih Ketua Tim</option>
                                            <option v-for="v in personil_data.ketuatim" :key="v.id" :value="v.nip">
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
                                            v-model="dinasboptimpengumpuldata.anggota"
                                            :options="anggota_data"
                                            track-by="key"
                                            label="label"
                                            :allow-empty="true">
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
                    locale: 'id'
                },
                dinasboptimpengumpuldata: {
                    'nomor_sp': '',
                    'tgl_sp': '',
                    'auditan': '',
                    'irban_id': '',
                    'ketuatim':'',
                    'anggota':[]
                },
                form:'',
                personil_data:[],
                anggota_data:[],
                audit_data:[],
                alert: {
                    error: false,
                    save: false,
                    duplicate: false
                },
                isLoading: false
            }
        },
        props: [
            'auditan_data',
            'driver_data',
            'irban_data',
            'dinasbop',
            'api',
            'route'
        ],
        methods: {
            formReady() {
                let formData = new FormData();
                formData.append('nomor_sp', this.dinasboptimpengumpuldata.nomor_sp);
                formData.append('tgl_sp', this.dinasboptimpengumpuldata.tgl_sp);
                formData.append('auditan', this.dinasboptimpengumpuldata.auditan);
                formData.append('irban_id', this.dinasboptimpengumpuldata.irban_id);
                formData.append('ketuatim', this.dinasboptimpengumpuldata.ketuatim);
                formData.append('anggota', JSON.stringify(this.dinasboptimpengumpuldata.anggota));
                return formData;
            },
            onSubmit(evt) {
                this.form = this.formReady();
                service.postUploadData(this.api, this.form)
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

            onChangeIrban(evt) {
                const irban = evt.target.value;
                service.fetchData('../../api/ajax/dinasbop/tujuan?dinas=pengumpuldata&act=create&dinasbop='+this.dinasbop+'&irban='+ irban)
                .then(response => {
                    this.dinasboptimpengumpuldata.auditan = '';
                    this.audit_data = response;
                })
                .catch(error => {
                    console.log(error);
                });

                service.fetchData('../../api/ajax/dinasbop/personil?irban='+ irban)
                .then(response => {
                    this.dinasboptimpengumpuldata.ketuatim = '';
                    this.dinasboptimpengumpuldata.anggota = '';
                    this.personil_data = response;
                    this.personil_data.anggota.forEach(item => {
                        this.anggota_data.push({'label': item.nama +' - '+ item.jabatan , 'key':item.nip})
                    });
                })
                .catch(error => {
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
                Object.keys(this.form).forEach(function(key,index) { self.data.form[key] = ''; });
                this.dinasboptimpengumpuldata.irban_id = '';
                this.dinasboptimpengumpuldata.auditan = '';
                this.dinasboptimpengumpuldata.nomor_sp = '';
                this.dinasboptimpengumpuldata.tgl_sp = '';
                this.dinasboptimpengumpuldata.ketuatim = '';
                this.dinasboptimpengumpuldata.anggota = [];
                this.dinasboptimpengumpuldata.driver = '';
            }
        },
        created() {
            this.$cookies.set("last_tab", "pengumpuldata");
            this.isLoading = true;
            this.audit_data = this.auditan_data;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
