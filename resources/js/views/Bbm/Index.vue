<template>
    <div>
        <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-right">
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <v-alert :alert="alert"></v-alert>
                        <transition name="fade">
                            <table class="table table-hover table-striped table-bordered" v-if="showTable == true">
                                <thead>
                                    <tr>
                                        <th style="width:50%; text-align:center;">Kabupaten / Kota</th>
                                        <th style="width:10%; text-align:center;">Takaran Liter</th>
                                        <th style="width:10%; text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="v in bbm" :key="v.id">
                                        <td>{{ v.kabkota.nama_kabkota }}</td>
                                        <td style="text-align:center;">{{ v.liter }}</td>
                                        <td>
                                            <div style="text-align: center;" v-if="(access.update === 1) & (access.delete === 1)">
                                                <a :href="route + '/edit?id=' + v.id" class="btn btn-sm btn-warning mr-sm-1">
                                                    <i class="fa fa-wrench"></i> Ubah
                                                </a>
                                            </div>
                                            <div style="text-align: center;" v-else>
                                                <button class="btn btn-sm btn-warning disabled mr-sm-1"><i class="fa fa-wrench"></i> Ubah</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import service from './../../services.js';

    export default {
    data: function() {
        return {
            bbm: {},
            alert: {
                error:false,
                empty:false,
                delete:false
            },
            isLoading: false,
            showTable: false,
            id:''
        }
    },
    props: ['api','route','access'],
    methods: {
        fetchData() {
            this.isLoading = true;
            service.fetchData(this.api)
            .then(response => {
                this.renderData(response);
            })
            .catch(error => {
                this.isLoading = false;
                this.alert.error = true;
                console.log(error);
            });
        },
        renderData(response) {
            if (response.total === 0) {
                this.showTable = false;
                this.alert.empty = true;
                this.alert.error = false;
            } else {
                this.showTable = true;
                this.alert.empty = false;
                this.alert.error = false;
                this.bbm = response;
            }
            this.isLoading = false;
        }
    },
    created() {
        this.isLoading = true;
        this.fetchData();
    }
};
</script>
