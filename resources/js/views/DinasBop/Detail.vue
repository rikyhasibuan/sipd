<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card table-responsive">
                <div class="card-body">
                    <loading :active.sync="isLoading" :can-cancel="false" :is-full-page="true"></loading>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#tim" :data-id="'tabtim'" @click="onChangeTabs($event)" :class="(last_tab == 'tim') ? 'active' : ''">
                                <i class="fa fa-users"></i> Tim
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#inspektur" :data-id="'tabinspektur'" @click="onChangeTabs($event)" :class="(last_tab == 'inspektur') ? 'active' : ''">
                                <i class="fa fa-user"></i> Inspektur
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#sekretaris" :data-id="'tabsekretaris'" @click="onChangeTabs($event)" :class="(last_tab == 'sekretaris') ? 'active' : ''">
                                <i class="fa fa-user"></i> Sekretaris
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#driver" :data-id="'tabdriver'" @click="onChangeTabs($event)" :class="(last_tab == 'driver') ? 'active' : ''">
                                <i class="fa fa-user"></i> Pengemudi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#reviu" :data-id="'tabreviu'" @click="onChangeTabs($event)" :class="(last_tab == 'reviu') ? 'active' : ''">
                                <i class="fa fa-user"></i> Reviu & Monitoring
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#supervisi" :data-id="'tabsupervisi'" @click="onChangeTabs($event)" :class="(last_tab == 'supervisi') ? 'active' : ''">
                                <i class="fa fa-user"></i> Supervisi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#pengumpuldata" :data-id="'tabpengumpuldata'" @click="onChangeTabs($event)" :class="(last_tab == 'pengumpuldata') ? 'active' : ''">
                                <i class="fa fa-user"></i> Pengumpul Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#administrasi" :data-id="'tabadministrasi'" @click="onChangeTabs($event)" :class="(last_tab == 'administrasi') ? 'active' : ''">
                                <i class="fa fa-user"></i> Pengadministrasi
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tim" class="tab-pane fade" :class="{ 'active': (last_tab == 'tim'), 'show': (last_tab == 'tim') }">
                            <dinasboptim-detail
                                :dinasbop=dinasbop
                                :dinasboptim=dinasboptim
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasboptim-detail>
                        </div>
                        <div id="inspektur" class="tab-pane fade" :class="{ 'active': (last_tab == 'inspektur'), 'show': (last_tab == 'inspektur') }">
                            <dinasbopinspektur-detail
                                :dinasbop=dinasbop
                                :dinasbopinspektur=dinasbopinspektur
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasbopinspektur-detail>
                        </div>
                        <div id="sekretaris" class="tab-pane fade" :class="{ 'active': (last_tab == 'sekretaris'), 'show': (last_tab == 'sekretaris') }">
                            <dinasbopsekretaris-detail
                                :dinasbop=dinasbop
                                :dinasbopsekretaris=dinasbopsekretaris
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasbopsekretaris-detail>
                        </div>
                        <div id="driver" class="tab-pane fade" :class="{ 'active': (last_tab == 'driver'), 'show': (last_tab == 'driver') }">
                            <dinasbopdriver-detail
                                :dinasbop=dinasbop
                                :dinasbopdriver=dinasbopdriver
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasbopdriver-detail>
                        </div>
                        <div id="reviu" class="tab-pane fade" :class="{ 'active': (last_tab == 'reviu'), 'show': (last_tab == 'reviu') }">
                            <dinasbopreviu-detail
                                :dinasbop=dinasbop
                                :dinasbopreviu=dinasbopreviu
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasbopreviu-detail>
                        </div>
                        <div id="supervisi" class="tab-pane fade" :class="{ 'active': (last_tab == 'supervisi'), 'show': (last_tab == 'supervisi') }">
                            <dinasbopsupervisi-detail
                                :dinasbop=dinasbop
                                :dinasbopdriver=dinasbopdriver
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasbopsupervisi-detail>
                        </div>
                        <div id="pengumpuldata" class="tab-pane fade" :class="{ 'active': (last_tab == 'pengumpuldata'), 'show': (last_tab == 'pengumpuldata') }">
                            <dinasboppengumpuldata-detail
                                :dinasbop=dinasbop
                                :dinasbopdriver=dinasbopdriver
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasboppengumpuldata-detail>
                        </div>
                        <div id="administrasi" class="tab-pane fade" :class="{ 'active': (last_tab == 'administrasi'), 'show': (last_tab == 'administrasi') }">
                            <dinasbopadministrasi-detail
                                :dinasbop=dinasbop
                                :dinasbopdriver=dinasbopdriver
                                :route=route
                                :print_action=print_action
                                :api=api>
                            </dinasbopadministrasi-detail>
                        </div>
                    </div>

                    <!--
                        <button type="button" class="btn btn-success" @click="approve()" v-show="dinasbop.status === 0" style="margin-right:5px;"><i class="fa fa-check"></i> Setujui</button>
                        <button type="button" class="btn btn-warning" @click="revisi()" v-show="dinasbop.status === 0" style="margin-right:5px;"><i class="fa fa-info"></i> Revisi</button>
                    -->
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
                last_tab: '',
                id:''
            }
        },
        props: ['dinasbop', 'dinasboptim', 'dinasbopdriver', 'dinasbopinspektur', 'dinasbopsekretaris','dinasbopreviu', 'route', 'print_action', 'api'],
        methods: {
            onChangeTabs(evt) {
                const data_set = evt.target.dataset.id;
                switch (data_set) {
                    case 'tabtim':
                        this.$cookies.set("last_tab", "tim");
                        break;
                    case 'tabdriver':
                        this.$cookies.set("last_tab", "driver");
                        break;
                    case 'tabinspektur':
                        this.$cookies.set("last_tab", "inspektur");
                        break;
                    case 'tabsekretaris':
                        this.$cookies.set("last_tab", "sekretaris");
                        break;
                    case 'tabreviu':
                        this.$cookies.set("last_tab", "reviu");
                        break;
                    case 'tabsupervisi':
                        this.$cookies.set("last_tab", "supervisi");
                        break;
                    case 'tabpengumpuldata':
                        this.$cookies.set("last_tab", "pengumpuldata");
                        break;
                    case 'tabadministrasi':
                        this.$cookies.set("last_tab", "administrasi");
                        break;
                    default:
                        break;
                }
            }
        },
        created() {
            this.isLoading = true;
            if (this.$cookies.isKey('last_tab') == false) {
                this.$cookies.set("last_tab", 'tim');
                this.last_tab = 'tim';
            } else {
                this.last_tab = this.$cookies.get("last_tab");
            }
        },
        mounted() {
            this.isLoading = false;
        }
    };
</script>
