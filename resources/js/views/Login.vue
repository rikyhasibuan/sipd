<template>
    <div>
        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
        <transition name="fade">
            <form v-on:submit.prevent="onSubmit" method="post">
                <div class="input-group mb-3">
                    <input type="text" v-model="nip" class="form-control" placeholder="NIP" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fa fa-user"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" v-model="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fa fa-lock"></span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-success btn-block"><i class="fa fa-lock"></i> LOGIN</button>
                        <div class="text-center" v-if="(login !== '') & (login === false)" style="margin-top:25px;">
                            <div class="alert alert-danger">NIP / Password Salah!</div>
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
            nip: "",
            password: "",
            login: "",
            form: "",
            isLoading:false
        };
    },
    props: ["api", "redirect"],
    methods: {
        formReady() {
            let formData = new FormData();
            formData.append("nip", this.nip);
            formData.append("password", this.password);
            return formData;
        },
        formReset() {
            Object.keys(this.form).forEach(function (key, index) {
                self.data.form[key] = "";
            });
            this.nip = "";
            this.password = "";
        },
        onSubmit(evt) {
            this.isLoading = true;
            this.form = this.formReady();
            service
                .postData(this.api, this.form)
                .then(result => {
                    if (result.login == "true") {
                        this.login = true;
                        this.generateCookie(result);
                        this.formReset();
                        window.location.href = this.redirect;
                    } else {
                        this.login = false;
                    }
                    this.isLoading = false;
                })
                .catch(error => {
                    this.formReset();
                    this.isLoading = false;
                    this.login = false;
                    this.$Progress.finish();
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