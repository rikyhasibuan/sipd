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
        <div class="alert alert-danger" v-if="alert.duplicatedate === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> DATA DINAS DENGAN RENTANG WAKTU YANG SAMA SUDAH TERSIMPAN DALAM RECORD SEBELUMNYA!
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
        <div class="alert alert-danger" v-if="alert.validate === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> SILAHKAN PERIKSA KEMBALI FORM ANDA!
        </div>
        <div class="alert alert-danger" v-if="alert.validatepassword === true" style="text-align: center;">
            <i class="fa fa-exclamation-triangle"></i> PASSWORD TIDAK SAMA! SILAHKAN ULANGI KEMBALI
        </div>
    </div>
</template>

<script>
export default {
    props: ['alert']
}
</script>
