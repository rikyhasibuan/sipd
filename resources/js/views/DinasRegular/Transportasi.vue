<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert=alert></v-alert>
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <form method="POST" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-6 col-xs-12">
                                <label for="bidang">Jenis Transportasi *</label>
                                <select v-model="transportasi.jenis" class="form-control" @change="onChangeJenisTransportasi" required="required">
                                    <option value="">Pilih Jenis Transportasi</option>
                                    <option v-for="(k,v) in this.jenis_transportasi" v-bind:value="k" v-bind:key="v">{{ v }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row" v-if="show_liter === true">
                            <div class="form-group col-md-6 col-xs-12">
                                <label>Liter *</label>
                                <select v-model="transportasi.liter" class="form-control" @change="onChangeLiter">
                                    <option value="">Pilih Jumlah Liter</option>
                                    <option v-for="(k,v) in this.liter" v-bind:value="k" v-bind:key="v">{{ v }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="nama">Total Biaya *</label>
                                <input type="text" v-model="transportasi.total" class="form-control" required="required">
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
              transportasi: {
                jenis:'',
                liter:'',
                total:''
              },
              liter: [],
              show_liter: false,
              isLoading: false,
          }
      },
      props: ['jenistransportasi','takaranbbm','dinasregular', 'api', 'route'],
      methods: {
          onChangeJenisTransportasi(evt) {
              const jenis = evt.target.value;
              if (jenis === 'BBM') {
                service.postUploadData('../api/ajax/bbmkabkota/', jenis)
                    .then(response => {
                        this.show_liter = true;
                        this.liter = response;
                    })
                    .catch(error => {
                        console.log(error);
                    });
              } else {
                this.liter
              }
          },
          onSubmit(evt) {
              this.isLoading = false;
              service.putData(this.api + '/transportasi', this.dinasregular)
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
