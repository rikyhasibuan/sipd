<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Bendahara</label>
                                <select v-model="report.bendahara" class="form-control">
                                    <option value="">Pilih Bendahara</option>
                                    <option v-for="v in this.bendahara_data" :value="v.id" :key="v.id">{{ v.nama }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Dari *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <date-picker
                                        id="dari"
                                        name="dari"
                                        v-model="report.dari"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Dari"
                                        :class="{ 'is-invalid': validasi.dari }"
                                        autocomplete="off">
                                    </date-picker>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Sampai *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <date-picker
                                        id="sampai"
                                        name="sampai"
                                        v-model="report.sampai"
                                        :config="options"
                                        class="form-control"
                                        placeholder="Sampai"
                                        :class="{ 'is-invalid': validasi.sampai }"
                                        autocomplete="off">
                                    </date-picker>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-file-excel"></i> Cetak Laporan</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>*) Wajib Diisi</b>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                alert: {
                    error:false,
                    update:false,
                    validate:false
                },
                report: {
                    dari:'',
                    sampai:'',
                    bendahara:''
                },
                validasi: {
                    'dari': '',
                    'sampai': ''
                },
                isLoading:false,
                options: {
                    format: 'YYYY-MM',
                    viewMode:'years',
                    useCurrent: false,
                    locale: 'id',
                    minDate:'2020/01/01'
                }
            }
        },
        props: ['api','route', 'bendahara_data'],
        methods: {
            onSubmit (evt) {
                evt.preventDefault();

                this.alert.error = false;
                this.alert.update = false;
                this.alert.validate = false;

                let validasi = this.validate();
                if (validasi === true) {
                    let newWindow = window.open();
                    newWindow.location = this.api + '?bendahara=' + this.report.bendahara + '&dari=' + this.report.dari + '&sampai=' + this.report.sampai;
                } else {
                    this.alert.validate = true;
                    setTimeout(() => this.alert.validate = false, 3000);
                }
            },
            validate() {
                let condition = 0;

                if (this.report.dari.length === 0) {
                    this.validasi.dari = true;
                    condition++;
                } else {
                    this.validasi.dari = false;
                }

                if (this.report.sampai.length === 0) {
                    this.validasi.sampai = true;
                    condition++;
                } else {
                    this.validasi.sampai = false;
                }

                if (condition > 0) {
                    return false;
                } else {
                    return true;
                }
            }
        },
        created() {
            this.isLoading = true;
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
