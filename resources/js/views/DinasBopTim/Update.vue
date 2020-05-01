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
                                    <input type="text" class="form-control" v-model="tim.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tanggal Surat Perintah *</label>
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
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Irban *</label>
                                    <select v-model="tim.irban_id" @change="onChangeIrban($event)" class="form-control" required="required">
                                        <option value="">Pilih Irban</option>
                                        <option v-for="v in this.irban_data" :value="v.id" :key="v.id">{{ v.nama_irban }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Auditan *</label>
                                    <select v-model="tim.auditan" class="form-control" required="required">
                                        <option value="">Pilih Auditan</option>
                                        <optgroup v-for="(k,v) in this.audit_data" :key="v" :label="v">
                                            <option v-for="val in k" :key="val" :value="val">{{ val }}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Wakil Penanggung Jawab *</label>
                                    <select v-model="tim.wakilpenanggungjawab" class="form-control" required="required">
                                        <option value="">Pilih Wakil Penanggung Jawab</option>
                                        <option v-for="v in personil_data" :key="v.pegawai.id" :value="v.pegawai.nip">{{ v.pegawai.nama }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Pengendali Teknis *</label>
                                    <select v-model="tim.pengendaliteknis" class="form-control" required="required">
                                        <option value="">Pilih Pengendali Teknis</option>
                                        <option v-for="v in personil_data" :key="v.pegawai.id" :value="v.pegawai.nip">{{ v.pegawai.nama }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Ketua Tim *</label>
                                    <select v-model="tim.ketuatim" class="form-control" required="required">
                                        <option value="">Pilih Ketua Tim</option>
                                        <option v-for="v in personil_data" :key="v.pegawai.id" :value="v.pegawai.nip">{{ v.pegawai.nama }}</option>
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
                                    <label>Lampirkan Bukti Pendukung (PDF / DOC / JPG / RAR / ZIP)</label>
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
                alert: {
                    error: false,
                    update: false
                },
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    locale: 'id'
                },
                personil_data:[],
                anggota_data:[],
                audit_data:[],
                isLoading: false,
                tim: {
                    'nomor_sp': '',
                    'tgl_sp': '',
                    'auditan': '',
                    'irban_id': '',
                    'wakilpenanggungjawab':'',
                    'pengendaliteknis':'',
                    'ketuatim':'',
                    'anggota':[],
                    'lampiran':''
                },
            }
        },
        props: [
            'auditan_data',
            'irban_data',
            'dinasbop',
            'dinasboptim',
            'api',
            'route'
        ],
        methods: {
            handleFileUpload() {
                this.tim.lampiran = this.$refs.file.files[0];
            },
            formReady() {
                let formData = new FormData();
                formData.append('nomor_sp', this.tim.nomor_sp);
                formData.append('tgl_sp', this.tim.tgl_sp);
                formData.append('auditan', this.tim.auditan);
                formData.append('irban_id', this.tim.irban_id);
                formData.append('wakilpenanggungjawab', this.tim.wakilpenanggungjawab);
                formData.append('pengendaliteknis', this.tim.pengendaliteknis);
                formData.append('ketuatim', this.tim.ketuatim);
                formData.append('anggota', JSON.stringify(this.tim.anggota));
                if(this.tim.lampiran !== '') {
                    formData.append('lampiran', this.tim.lampiran);
                }

                /*  for( var i = 0; i < this.lampiran.length; i++ ){
                    let file = this.lampiran[i];
                    formData.append('lampiran[' + i + ']', file);
                } */
                return formData;
            },
            onSubmit(evt) {
                this.isLoading = false;

                this.form = this.formReady();
                service.postUploadData(this.api + '/tim/' + this.dinasbop + '/' + this.dinasboptim.id, this.form)
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
            },
            onChangeIrban(evt) {
                const irban = evt.target.value;

                // ambil data auditan berdasarkan irban
                service.fetchData('../../api/ajax/dinasbop/tujuan/'+ irban)
                .then(response => {
                    this.tim.auditan = '';
                    this.audit_data = response;
                })
                .catch(error => {
                    this.isLoading = false;
                    this.alert.error = true;
                    console.log(error);
                });

                // ambil data personil berdasarkan irban
                service.fetchData('../../api/ajax/dinasbop/personil/'+ irban)
                .then(response => {
                    this.tim.wakilpenanggungjawab = '';
                    this.tim.pengendaliteknis = '';
                    this.tim.ketuatim = '';
                    this.tim.anggota = [];
                    this.personil_data = response;
                    this.personil_data.forEach(item => {
                        this.anggota_data.push({'label':item.pegawai.nama,'key':item.pegawai.nip})
                    });
                })
                .catch(error => {
                    this.isLoading = false;
                    this.alert.error = true;
                    console.log(error);
                });
            }
        },
        created() {
            this.isLoading = true;
            this.tim.irban_id = this.dinasboptim.irban_id;
            this.tim.auditan = this.dinasboptim.auditan;
            this.tim.nomor_sp = this.dinasboptim.nomor_sp;
            this.tim.tgl_sp = this.dinasboptim.tgl_sp;
            this.tim.wakilpenanggungjawab = this.dinasboptim.tim.wakilpenanggungjawab.nip;
            this.tim.pengendaliteknis = this.dinasboptim.tim.pengendaliteknis.nip;
            this.tim.ketuatim = this.dinasboptim.tim.ketuatim.nip;

            const irban = this.dinasboptim.irban_id;

            // ambil data auditan berdasarkan irban
            service.fetchData('../../api/ajax/dinasbop/tujuan/'+ irban)
            .then(response => {
                this.audit_data = response;
            })
            .catch(error => {
                console.log(error);
            });

            // ambil data personil berdasarkan irban
            service.fetchData('../../api/ajax/dinasbop/personil/'+ irban)
            .then(response => {
                this.personil_data = response;
                this.personil_data.forEach(item => {
                    this.anggota_data.push({'label':item.pegawai.nama,'key':item.pegawai.nip});
                });
            })
            .catch(error => {
                console.log(error);
            });

            let anggota = this.dinasboptim.tim.anggota;
            anggota.forEach(item => {
                this.tim.anggota.push({'label':item.nama,'key':item.nip});
            });
        },
        mounted() {
            this.isLoading = false;
            console.log(this.tim.anggota);
        }
    };
</script>
