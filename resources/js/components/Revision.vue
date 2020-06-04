<template>
    <div>
        <div class="modal fade" :id="element" tabindex="-1" role="dialog" @close="close">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Revisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="row">
                                <div class="form-group col-md-12 col-xs-12">
                                    <label>Catatan Revisi *</label>
                                    <textarea class="form-control" v-model="catatan" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-success" @click.prevent="createRevision()"><i class="fa fa-check"></i> Simpan</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                catatan: ''
            }
        },
        props: ['role','element'],
        methods: {
            close() {
                this.$emit('close');
            },
            createRevision() {
                this.$emit('revision', { catatan:this.catatan, role:this.role });
            }
        }
    };
</script>
