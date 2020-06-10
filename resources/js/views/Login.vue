<template>
    <div>
        <loading :opacity="100" :active.sync="isLoading" :can-cancel="false" :is-full-page="false"></loading>
        <transition name="fade">
            <form v-on:submit.prevent="onSubmit" method="post">
                <div class="input-group mb-3">
                    <input type="text" v-model="userlogin.nip" class="form-control" placeholder="NIP" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fa fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" v-model="userlogin.password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fa fa-lock"></span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-block"><i class="fa fa-lock"></i> LOGIN</button>
                        <div class="text-center" v-if="(login !== '') && (login === false)" style="margin-top:25px;">
                            <div class="alert alert-danger">NIP / Password Salah!</div>
                        </div>
                        <div class="text-center" v-if="(status !== '') && (status === 'inactive')" style="margin-top:25px;">
                            <div class="alert alert-danger">Status User Tidak Aktif!</div>
                        </div>
                    </div>
                </div>
            </form>
        </transition>
    </div>
</template>

<script>
import service from './../services.js';

export default {
    data: function () {
        return {
            userlogin : {
                nip: "",
                password: ""
            },
            login: "",
            form: "",
            status:"",
            isLoading:false
        };
    },
    props: ["api", "redirect"],
    methods: {
        formReset() {
            this.userlogin.nip = "";
            this.userlogin.password = "";
        },
        onSubmit(evt) {
            this.isLoading = true;
            service
                .postData(this.api, this.userlogin)
                .then(result => {
                    if (result.login == "true") {
                        this.login = true;
                        this.generateCookie(result);
                        this.$cookies.set('nip', result.nip);
                        this.$cookies.set('id', result.id);
                        this.$cookies.set('level', result.level);
                        this.$cookies.set('jabatan', result.jabatan);
                        this.$cookies.set('login', result.login);
                        this.formReset();
                        window.location.href = this.redirect;
                    } else if(result.login === 'inactive') {
                        this.login = false;
                    } else {
                        this.login = false;
                    }
                    this.isLoading = false;
                })
                .catch(error => {
                    this.formReset();
                    this.isLoading = false;
                    this.login = false;
                    this.isLoading = false;
                });
        },
        generateCookie(result) {
            this.$cookies.set("nip", result.nip);
            this.$cookies.set("id", result.id);
            this.$cookies.set("level", result.level);
            this.$cookies.set("login", result.login);
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
