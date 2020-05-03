<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card table-responsive">
                <div class="card-body">
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link active" href="#tim"><i class="fa fa-users"></i> Tim</a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#driver"><i class="fa fa-car"></i> Pengemudi</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tim" class="tab-pane fade show active">
                            <dinasboptim-detail 
                                :dinasbop=dinasbop 
                                :dinasboptim=dinasboptim
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasboptim-detail>
                        </div>
                        <div id="driver" class="tab-pane fade">
                            <dinasbopdriver-detail 
                                :dinasbop=dinasbop 
                                :dinasbopdriver=dinasbopdriver
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasbopdriver-detail>
                        </div>
                    </div>
                    <!-- 
                        <button type="button" class="btn btn-success" @click="approve()" v-show="dinasbop.status === 0" style="margin-right:5px;"><i class="fa fa-check"></i> Setujui</button>
                        <button type="button" class="btn btn-warning" @click="revisi()" v-show="dinasbop.status === 0" style="margin-right:5px;"><i class="fa fa-info"></i> Revisi</button>
                    -->
                    <button v-if="dinasbop.tim != null" type="button" class="btn btn-default" @click="print_personil_all(dinasbop.id)" style="margin-right:5px;"><i class="fa fa-print"></i> Cetak Daftar Personil</button>
                    <a :href="route" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            options: {},
            alert: {
                error:false,
                empty:false,
                delete:false
            },
            showTable: false,
            id:''
        }
    },
    props: ['dinasbop','dinasboptim', 'dinasbopdriver', 'route','print_action','api'],
    created() {
        this.isLoading = true;
    },
    mounted() {
        this.isLoading = false;
    }
};
</script>
