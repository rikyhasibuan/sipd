<template>
    <div>
        <div class="alert alert-danger" role="alert" v-if="alert.empty === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> DATA TIDAK DITEMUKAN
        </div>
        <div class="alert alert-danger" v-if="alert.error === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> TERJADI KESALAHAN! SILAHKAN ULANGI KEMBALI!
        </div>
        <div class="alert alert-danger" v-if="alert.duplicate === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> DATA YANG SAMA SUDAH TERSIMPAN DALAM RECORD SEBELUMNYA!
        </div>
        <div class="alert alert-success" v-if="alert.delete === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> DATA BERHASIL DIHAPUS!
        </div>
        <div class="alert alert-success" v-if="alert.save === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> DATA BERHASIL DISIMPAN!
        </div>
        <div class="alert alert-success" v-if="alert.update === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> DATA BERHASIL DIPERBAHARUI!
        </div>
        <div class="alert alert-success" v-if="alert.reg === true">
            <h4><i class="icon fa fa-send-o"></i> Konsultasi Berhasil Dikirim!</h4>
            Tim kami akan segera mengkaji konsultasi Anda. Mohon tunggu respon dari kami dalam 1-2 hari kerja. Terima Kasih.
        </div>
    </div>
</template>

<script>
export default {
    props: ['alert']
}
</script>
