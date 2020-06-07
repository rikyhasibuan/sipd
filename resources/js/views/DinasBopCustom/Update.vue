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
                                <div class="form-group col-md-4">
                                    <label>Nomor Surat Perintah *</label>
                                    <input type="text" class="form-control" v-model="timcustom.nomor_sp" placeholder="Isi Nomor Surat Perintah" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tanggal Surat Perintah *</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        <date-picker
                                            id="tgl_sp"
                                            name="tgl_sp"
                                            v-model="timcustom.tgl_sp"
                                            :config="options"
                                            class="form-control"
                                            placeholder="Tanggal Surat Perintah" autocomplete="off" required>
                                        </date-picker>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Auditan *</label>
                                    <select v-model="timcustom.auditan" class="form-control" required>
                                        <option value="">Pilih Auditan</option>
                                        <optgroup v-for="(k,v) in this.auditan_data" :key="v" :label="v">
                                            <option v-for="val in k" :key="val" :value="val">{{ val }}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Penanggung Jawab *</label>
                                    <select v-model="timcustom.penanggungjawab" class="form-control" required>
                                        <option value="">Pilih Penanggung Jawab</option>
                                        <option v-for="v in personil_data.penanggungjawab" :key="v.id" :value="v.nip">
                                            {{ v.nama }} - {{ v.jabatan }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Wakil Penanggung Jawab *</label>
                                    <select v-model="timcustom.wakilpenanggungjawab" class="form-control" required>
                                        <option value="">Pilih Wakil Penanggung Jawab</option>
                                        <option v-for="v in personil_data.wakilpenanggungjawab" :key="v.id" :value="v.nip">
                                            {{ v.nama }} - {{ v.jabatan }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Pengendali Teknis *</label>
                                    <select v-model="timcustom.pengendaliteknis" class="form-control" required>
                                        <option value="">Pilih Pengendali Teknis</option>
                                        <option v-for="v in personil_data.pengendaliteknis" :key="v.id" :value="v.nip">
                                            {{ v.nama }} - {{ v.jabatan }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Ketua Tim *</label>
                                    <select v-model="timcustom.ketuatim" class="form-control" required>
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
                                        v-model="timcustom.anggota"
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
                                    <label>Lampirkan Bukti Pendukung (PDF / DOC / JPG / RAR / ZIP)</label>
                                    <br>
                                    <input type="file" ref="file" @change="handleFileUpload()">
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
                timcustom: {
                    'nomor_sp': '',
                    'tgl_sp': '',
                    'auditan': '',
                    'penanggungjawab':'',
                    'wakilpenanggungjawab':'',
                    'pengendaliteknis':'',
                    'ketuatim':'',
                    'anggota':[],
                    'lampiran':''
                },
                form:'',
                anggota_data:[],
                audit_data:[],
                alert: {
                    error: false,
                    update: false
                },
                isLoading: false,
                usernip:''
            }
        },
        props: [
            'auditan_data',
            'personil_data',
            'dinasbop',
            'dinasbop_data',
            'dinasbopcustom',
            'api',
            'route'
        ],
        methods: {
            handleFileUpload() {
                this.timcustom.lampiran = this.$refs.file.files[0];
            },
            formReady() {
                let formData = new FormData();
                formData.append('nomor_sp', this.timcustom.nomor_sp);
                formData.append('tgl_sp', this.timcustom.tgl_sp);
                formData.append('auditan', this.timcustom.auditan);
                formData.append('penanggungjawab', this.timcustom.penanggungjawab);
                formData.append('wakilpenanggungjawab', this.timcustom.wakilpenanggungjawab);
                formData.append('pengendaliteknis', this.timcustom.pengendaliteknis);
                formData.append('ketuatim', this.timcustom.ketuatim);
                formData.append('anggota', JSON.stringify(this.timcustom.anggota));
                if(this.timcustom.lampiran !== '') {
                    formData.append('lampiran', this.timcustom.lampiran);
                }

                return formData;
            },
            onSubmit(evt) {
                this.isLoading = false;

                this.form = this.formReady();
                service.postUploadData(this.api + '/custom/edit?nip='+this.usernip+'&dinasbop='+this.dinasbop+'&id='+this.dinasbopcustom.id, this.form)
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
            this.$cookies.set("last_tab", "custom");
            this.isLoading = true;
            this.timcustom.auditan = this.dinasbopcustom.auditan;
            this.timcustom.nomor_sp = this.dinasbopcustom.nomor_sp;
            this.timcustom.tgl_sp = this.dinasbopcustom.tgl_sp;
            this.timcustom.penanggungjawab = this.dinasbopcustom.tim.penanggungjawab.nip;
            this.timcustom.wakilpenanggungjawab = this.dinasbopcustom.tim.wakilpenanggungjawab.nip;
            this.timcustom.pengendaliteknis = this.dinasbopcustom.tim.pengendaliteknis.nip;
            this.timcustom.ketuatim = this.dinasbopcustom.tim.ketuatim.nip;

            this.personil_data.anggota.forEach(item => {
                this.anggota_data.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });

            let anggota = this.dinasbopcustom.tim.anggota;
            anggota.forEach(item => {
                this.timcustom.anggota.push({'label': item.nama +' - '+ item.jabatan,'key':item.nip});
            });
        },
        mounted() {
            this.isLoading = false;
            this.usernip = this.$cookies.get('nip');
        }
    };
</script>
