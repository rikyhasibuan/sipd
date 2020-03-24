<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username">Nomor Surat Perintah *</label>
                                    <input type="text" class="form-control" v-model="tim.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="username">Tanggal Surat Perintah *</label>
                                    <input type="date" class="form-control" v-model="tim.tgl_sp" placeholder="Isi Tanggal Surat Perintah" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Irban *</label>
                                    <select v-model="tim.irban_id" @change="onChangeIrban($event)" class="form-control" required="required">
                                        <option value="">Pilih Irban</option>
                                        <option v-for="v in this.irban_data" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_irban }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Auditan *</label>
                                    <select v-model="tim.auditan" class="form-control" required="required">
                                        <option value="">Pilih Auditan</option>
                                        <optgroup v-for="(k,v) in this.audit_data" :key="v" :label="v">
                                            <option v-for="val in k" :key="val" :value="val">{{ val }}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Wakil Penanggung Jawab *</label>
                                    <select v-model="tim.wakilpenanggungjawab" class="form-control" required="required">
                                        <option value="">Pilih Wakil Penanggung Jawab</option>
                                        <option v-for="v in personil_data" :key="v.pegawai.id" :value="v.pegawai.nip">{{ v.pegawai.nip }} - {{ v.pegawai.nama }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Pengendali Teknis *</label>
                                    <select v-model="tim.pengendaliteknis" class="form-control" required="required">
                                        <option value="">Pilih Pengendali Teknis</option>
                                        <option v-for="v in personil_data" :key="v.pegawai.id" :value="v.pegawai.nip">{{ v.pegawai.nama }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Ketua Tim *</label>
                                    <select v-model="tim.ketuatim" class="form-control" required="required">
                                        <option value="">Pilih Ketua Tim</option>
                                        <option v-for="v in personil_data" :key="v.pegawai.id" :value="v.pegawai.nip">{{ v.pegawai.nama }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Anggota *</label>
                                    <multiselect 
                                        :multiple="true"
                                        :taggable="true"
                                        placeholder="Pilih Anggota"
                                        v-model="tim.anggota"
                                        :value="anggota_data.key"
                                        :options="anggota_data"
                                        track-by="key"
                                        label="label"
                                        :allow-empty="true"
                                        class="multiselect"
                                    >
                                    </multiselect>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bidang">Pengemudi *</label>
                                    <select v-model="tim.driver" class="form-control" required="required">
                                        <option value="">Pilih Pengemudi</option>
                                        <option v-for="v in driver_data" :key="v.id" :value="v.nip">{{ v.nama }}</option>
                                    </select>
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
                personil_data:[],
                anggota_data:[],
                audit_data:[],
                isLoading: false,
                tim: {
                    'auditan': '',
                    'irban_id': '',
                    'wakilpenanggungjawab':'',
                    'pengendaliteknis':'',
                    'ketuatim':'',
                    'anggota':[],
                    'driver':''
                },
            }
        },
        props: [
            'auditan_data',
            'driver_data',
            'irban_data',
            'dinasbop',
            'dinasboptim',
            'api',
            'route'
        ],
        methods: {
            onSubmit(evt) {
                this.isLoading = false;
                service.putData(this.api + '/tim/' + this.dinasbop + '/' + this.dinasboptim.id, this.tim)
                    .then(result => {
                        this.response(result);
                    }).catch(error => {
                        this.isLoading = false;
                        this.alert.error = true;
                        window.scroll({
                            top: 0,
                            left: 0,
                            behavior: 'smooth'
                        });
                        console.log(error);
                    });
            },
            response(result) {
                if (result.status === 'OK') {
                    this.alert.error = false;
                    this.alert.update = true;
                    window.scroll({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    });
                    setTimeout(() => this.alert.update = false, 5000);
                }
                this.isLoading = false;
            },
            onChangeIrban(evt) {
                const irban = evt.target.value;

                // ambil data auditan berdasarkan irban
                service.fetchData(this.api + '/tujuan/'+ irban)
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
                service.fetchData(this.api + '/personil/'+ irban)
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
            this.tim.driver = this.dinasboptim.tim.driver.nip;
            
            const irban = this.dinasboptim.irban_id;

            // ambil data auditan berdasarkan irban
            service.fetchData(this.api + '/tujuan/'+ irban)
            .then(response => {
                this.audit_data = response;
            })
            .catch(error => {
                console.log(error);
            });

            // ambil data personil berdasarkan irban
            service.fetchData(this.api + '/personil/'+ irban)
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