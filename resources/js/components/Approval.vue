<template>
    <div>
        <div class="modal" id="approval_modal" tabindex="-1" role="dialog" @close="close">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><p>Anda Akan Menyetujui Data Dinas Ini, Teruskan?</p></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" @click="approveButton">
                            <i class="fa fa-check-circle-o"></i> Ya
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times-circle-o"></i> Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['role'],
        methods: {
            close() {
                this.$emit('close');
            },
            approveButton() {
                this.$emit('approve', this.role);
            }
        }
    };
</script>
