<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit" autocomplete="off">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nomor_sp">Nomor Surat Perintah </label>
                                <input id="nomor_sp" type="text" class="form-control" v-model="dinasregular.nomor_sp" placeholder="Isi Nomor Surat Perintah" required="required">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tgl_sp">Tanggal Surat Perintah </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <date-picker
                                        id="tgl_sp"
                                        name="tgl_sp"
                                        v-model="dinasregular.tgl_sp"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Tanggal Surat Perintah"
                                        autocomplete="off">
                                    </date-picker>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="program">Program *</label>
                                <select id="program" v-model="dinasregular.program_id" @change="onChangeProgram($event)" class="form-control" required="required">
                                    <option value="">Pilih Program</option>
                                    <option v-for="v in this.program" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_program }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="kegiatan">Kegiatan *</label>
                                <select id="kegiatan" v-model="dinasregular.kegiatan_id" @change="onChangeKegiatan($event)" class="form-control" required="required">
                                    <option value="">Pilih Kegiatan</option>
                                    <option v-for="v in this.kegiatan" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_kegiatan }}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="belanja">Belanja *</label>
                                <select id="belanja" v-model="dinasregular.belanja_id" class="form-control" required="required">
                                    <option value="">Pilih Belanja</option>
                                    <option v-for="v in this.belanja" v-bind:value="v.id" v-bind:key="v.id">{{ v.nama_belanja }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="dasar">Dasar Surat Perintah (wajib diisi minimal 1 kolom) *</label>
                                <input id="dasar" type="text" class="form-control" v-model="dinasregular.dasar[0]" required="required">
                                <br>
                                <input id="dasar1" type="text" class="form-control" v-model="dinasregular.dasar[1]">
                                <br>
                                <input id="dasar2" type="text" class="form-control" v-model="dinasregular.dasar[2]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="tujuan">Tujuan (wajib diisi minimal 1 kolom) *</label>
                                <input id="tujuan" type="text" class="form-control" v-model="dinasregular.untuk[0]" required="required">
                                <br>
                                <input id="tujuan1" type="text" class="form-control" v-model="dinasregular.untuk[1]">
                                <br>
                                <input id="tujuan2" type="text" class="form-control" v-model="dinasregular.untuk[2]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="dari">Tanggal Mulai *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <date-picker
                                        id="dari"
                                        name="dari"
                                        v-model="dinasregular.dari"
                                        :config="options"
                                        class="form-control disabled"
                                        placeholder="Tanggal Mulai"
                                        autocomplete="off"
                                        disabled>
                                    </date-picker>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sampai">Tanggal Selesai *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <date-picker
                                        id="sampai"
                                        name="sampai"
                                        v-model="dinasregular.sampai"
                                        :config="options"
                                        class="form-control disabled"
                                        placeholder="Tanggal Selesai"
                                        autocomplete="off"
                                        disabled>
                                    </date-picker>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="auditan">Tempat Tujuan *</label>
                                <select id="auditan" v-model="dinasregular.auditan" class="form-control" required="required">
                                    <option value="">Pilih Tempat Tujuan</option>
                                    <option v-for="v in this.auditan_data" :key="v.id" :value="v.nama_kabkota">{{ v.nama_kabkota }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="personil">Personil *</label>
                                <multiselect
                                    id="personil"
                                    :multiple="true"
                                    :taggable="true"
                                    placeholder="Pilih Personil"
                                    v-model="tim_data"
                                    :options="personil_data"
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
                auditan: '',
                program: '',
                kegiatan: '',
                belanja: '',
                personil_data: [],
                tim_data:[],
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                    locale: 'id'
                },
                isLoading: false,
            }
        },
        props: [
            'dinasregular',
            'program_data',
            'kegiatan_data',
            'belanja_data',
            'tujuan_data',
            'auditan_data',
            'anggota_data',
            'api',
            'route'
        ],
        methods: {
            onSubmit() {
                this.isLoading = false;
                this.dinasregular.tim = this.tim_data;
                service.putData(this.api, this.dinasregular)
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
            onChangeProgram(evt) {
                const program = evt.target.value;
                service.fetchData('../api/ajax/kegiatan/' + program)
                    .then(response => {
                        this.dinasregular.kegiatan_id = '';
                        this.dinasregular.belanja_id = '';
                        this.kegiatan = response;
                        this.belanja = [];
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            onChangeKegiatan(evt) {
                const kegiatan = evt.target.value;
                service.fetchData('../api/ajax/belanja/' + kegiatan)
                    .then(response => {
                        this.dinasregular.belanja_id = '';
                        this.belanja = response;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            response(result) {
                if (result.status === 'ok') {
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
            }
        },
        created() {
            this.isLoading = true;
            this.program = this.program_data;
            this.kegiatan = this.kegiatan_data;
            this.belanja = this.belanja_data;

            service.fetchData('../api/ajax/kegiatan/' + this.dinasregular.program_id)
            .then(response => {
                this.kegiatan = response;
            })
            .catch(error => {
                console.log(error);
            });

            service.fetchData('../api/ajax/belanja/' + this.dinasregular.kegiatan_id)
            .then(response => {
                this.belanja = response;
            })
            .catch(error => {
                console.log(error);
            });

            this.anggota_data.forEach(item => {
                this.personil_data.push({'label': item.nama +' - '+ item.jabatan , 'key':item.nip});
            });

            this.dinasregular.tim.forEach(item => {
                this.tim_data.push({'label': item.nama +' - '+ item.jabatan , 'key':item.nip});
            });
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
