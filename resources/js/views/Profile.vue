<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <v-alert :alert="alert"></v-alert>
                    <form method="POST" class="form-vertical" v-on:submit.prevent="onSubmit">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Password Baru</label>
                                <input type="text" class="form-control" v-model="backuser.password" placeholder="Masukkan Password Baru">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Konfirmasi Password</label>
                                <input type="text" class="form-control" v-model="backuser.repassword" placeholder="Konfirmasi Password Baru">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-flat btn-success"><i class="fa fa-save"></i> Simpan Data</button>
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
            isLoading:false,
            alert: {
              error:false,
              update:false
            },
            backuser: {
                password:'',
                repassword:'',
                id:this.$cookies.get('id')
            }
        }
    },
    props: ['api','user'],
    methods: {
        formReset() {
            this.backuser.password = '';
            this.backuser.repassword = '';
        },
        onSubmit () {
            this.isLoading = true;
            service.putData(this.api, this.backuser)
            .then(result => {
                if (result.status === 'OK') {
                    this.alert.error = false;
                    this.alert.update = true;
                    window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                    this.formReset();
                    setTimeout(() => this.alert.update = false, 5000);
                }
            }).catch(error => {
                this.alert.error = true;
                this.alert.update = false;
                window.scroll({ top: 0, left: 0, behavior: 'smooth' });
                console.log(error);
            });
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
