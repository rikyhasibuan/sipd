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
                                    <input type="text" class="form-control" v-model="tim.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
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
                                            v-model="tim.tgl_sp"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Surat Perintah" autocomplete="off">
                                        </date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Auditan *</label>
                                    <select v-model="tim.auditan" class="form-control" required="required">
                                        <option value="">Pilih Auditan</option>
                                        <optgroup v-for="(k,v) in this.auditan_data" :key="v" :label="v">
                                            <option v-for="val in k" :key="val" :value="val">{{ val }}</option>
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Ketua Tim *</label>
                                    <select v-model="tim.ketuatim" class="form-control" required="required">
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
                                        v-model="tim.anggota"
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
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    locale: 'id'
                },
                anggota_data:[],
                audit_data:[],
                isLoading: false,
                tim: {
                    'nomor_sp': '',
                    'tgl_sp': '',
                    'auditan': '',
                    'ketuatim':'',
                    'anggota':[]
                },
            }
        },
        props: [
            'auditan_data',
            'anggota',
            'ketua',
            'dinasbop',
            'dinasboptimpengumpuldata',
            'api',
            'route'
        ],
        methods: {
            formReady() {
                let formData = new FormData();
                formData.append('nomor_sp', this.tim.nomor_sp);
                formData.append('tgl_sp', this.tim.tgl_sp);
                formData.append('auditan', this.tim.auditan);
                formData.append('ketuatim', this.tim.ketuatim);
                formData.append('anggota', JSON.stringify(this.tim.anggota));
                return formData;
            },
            onSubmit(evt) {
                this.isLoading = false;
                this.form = this.formReady();
                service.putData(this.api, this.tim)
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
            this.$cookies.set("last_tab", "pengumpuldata");
            this.isLoading = true;
            this.tim.auditan = this.dinasboptimpengumpuldata.auditan;
            this.tim.nomor_sp = this.dinasboptimpengumpuldata.nomor_sp;
            this.tim.tgl_sp = this.dinasboptimpengumpuldata.tgl_sp;
            this.tim.ketuatim = this.dinasboptimpengumpuldata.tim.ketuatim.nip;

            let anggota_list = this.dinasboptimpengumpuldata.tim.anggota;
            anggota_list.forEach(item => {
                this.tim.anggota.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });

            this.anggota.forEach(item => {
                this.anggota_data.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
