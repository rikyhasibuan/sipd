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
                                <label>JENIS REPORT *</label>
                                <select v-model="report.jenis" class="form-control" required="required">
                                    <option value="pemagangan">DATA MAGANG</option>
                                    <option value="penempatan">DATA PENEMPATAN</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>PERUSAHAAN *</label>
                                <select v-model="report.perusahaan" class="form-control" required="required">
                                    <option value="">PILIH PERUSAHAAN</option>
                                    <option v-for="v in perusahaan_data" :value="v.id" :key="v.id">{{ v.nama_perusahaan.toUpperCase() }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success"><i class="fa fa-file-excel"></i> EXPORT</button>
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
          update:false
        },
        report: {
          jenis:'pemagangan',
          perusahaan:''
        },
        isLoading:false,
        options: {
          format: 'YYYY-MM-DD',
          useCurrent: false,
          locale: 'id'
        }
      }
    },
    props: ['api','route','perusahaan_data'],
    methods: {
      onSubmit (evt) {
        let newWindow = window.open();
        newWindow.location = this.api + '?perusahaan='+ this.report.perusahaan +'&jenis='+this.report.jenis;
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
