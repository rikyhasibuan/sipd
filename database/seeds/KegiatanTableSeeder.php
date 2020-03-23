<?php

use Illuminate\Database\Seeder;

class KegiatanTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('kegiatan')->delete();
        
        \DB::table('kegiatan')->insert(array (
            0 => 
            array (
                'id' => 1,
                'program_id' => 1,
                'bendahara' => 25,
                'kode_kegiatan' => '001',
                'nama_kegiatan' => 'Pembangunan Zona Integritas Pemerintah Daerah Provinsi Jawa Barat',
                'created_at' => '2020-02-28 04:05:12',
                'updated_at' => '2020-02-27 21:05:12',
            ),
            1 => 
            array (
                'id' => 2,
                'program_id' => 1,
                'bendahara' => 21,
                'kode_kegiatan' => '002',
                'nama_kegiatan' => 'Pembinaan, monitoring, dan evaluasi RADPPK Provinsi Jawa Barat',
                'created_at' => '2020-02-28 04:04:58',
                'updated_at' => '2020-02-27 21:04:58',
            ),
            2 => 
            array (
                'id' => 3,
                'program_id' => 1,
                'bendahara' => 21,
                'kode_kegiatan' => '004',
                'nama_kegiatan' => 'Peningkatan Maturitas Sistem Pengendalian Intern Pemerintah Provinsi Jawa Barat',
                'created_at' => '2020-02-28 04:04:40',
                'updated_at' => '2020-02-27 21:04:40',
            ),
            3 => 
            array (
                'id' => 4,
                'program_id' => 1,
                'bendahara' => 26,
                'kode_kegiatan' => '006',
                'nama_kegiatan' => 'Survei Indeks Integritas',
                'created_at' => '2020-02-28 04:04:21',
                'updated_at' => '2020-02-27 21:04:21',
            ),
            4 => 
            array (
                'id' => 5,
                'program_id' => 2,
                'bendahara' => 25,
                'kode_kegiatan' => '001',
                'nama_kegiatan' => 'Pelaksanaan layanan konsultasi/Desk Akuntabilitas',
                'created_at' => '2020-02-28 03:53:33',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'program_id' => 2,
                'bendahara' => 21,
                'kode_kegiatan' => '003',
                'nama_kegiatan' => 'Peningkatan Kapabilitas dan Integritas APIP',
                'created_at' => '2020-02-28 04:03:58',
                'updated_at' => '2020-02-27 21:03:58',
            ),
            6 => 
            array (
                'id' => 7,
                'program_id' => 2,
                'bendahara' => 26,
                'kode_kegiatan' => '004',
            'nama_kegiatan' => 'Penyusunan Program Kerja Pengawasan Tahunan (PKPT) Berbasis Risiko',
                'created_at' => '2020-02-28 04:03:42',
                'updated_at' => '2020-02-27 21:03:42',
            ),
            7 => 
            array (
                'id' => 8,
                'program_id' => 3,
                'bendahara' => 26,
                'kode_kegiatan' => '001',
                'nama_kegiatan' => 'Pembinaan dan evaluasi SAKIP Pemerintah Daerah Kab/Kota melalui sosialisasi dan evaluasi',
                'created_at' => '2020-02-28 04:03:33',
                'updated_at' => '2020-02-27 21:03:33',
            ),
            8 => 
            array (
                'id' => 9,
                'program_id' => 3,
                'bendahara' => 26,
                'kode_kegiatan' => '002',
                'nama_kegiatan' => 'Pembinaan dan Evaluasi SAKIP PD Provinsi Jawa Barat',
                'created_at' => '2020-02-28 04:03:17',
                'updated_at' => '2020-02-27 21:03:17',
            ),
            9 => 
            array (
                'id' => 10,
                'program_id' => 3,
                'bendahara' => 26,
                'kode_kegiatan' => '003',
                'nama_kegiatan' => 'Reviu atas LKIP Pemerintah Daerah Provinsi Jawa Barat',
                'created_at' => '2020-02-28 04:03:01',
                'updated_at' => '2020-02-27 21:03:01',
            ),
            10 => 
            array (
                'id' => 11,
                'program_id' => 4,
                'bendahara' => 25,
                'kode_kegiatan' => '001',
                'nama_kegiatan' => 'Fasilitasi dan koordinasi pelaksanaan tindak lanjut hasil pemeriksaan BPKRI',
                'created_at' => '2020-02-28 04:02:39',
                'updated_at' => '2020-02-27 21:02:39',
            ),
            11 => 
            array (
                'id' => 12,
                'program_id' => 4,
                'bendahara' => 26,
                'kode_kegiatan' => '002',
            'nama_kegiatan' => 'Monitoring dan Evaluasi Dana Desa dan Biaya Operasional Sekolah (BOS)',
                'created_at' => '2020-02-28 04:02:17',
                'updated_at' => '2020-02-27 21:02:17',
            ),
            12 => 
            array (
                'id' => 13,
                'program_id' => 4,
                'bendahara' => 26,
                'kode_kegiatan' => '003',
                'nama_kegiatan' => 'Pemeriksaan Bantuan Keuangan, Hibah dan Bantuan Sosial dari APBD Provinsi kepada Pemerintah Daerah Kab/Kota',
                'created_at' => '2020-02-28 04:02:02',
                'updated_at' => '2020-02-27 21:02:02',
            ),
            13 => 
            array (
                'id' => 14,
                'program_id' => 4,
                'bendahara' => 26,
                'kode_kegiatan' => '004',
            'nama_kegiatan' => 'Reviu atas Laporan Keuangan Pemerintah Daerah (LKPD) Provinsi Jawa Barat',
                'created_at' => '2020-02-28 04:01:49',
                'updated_at' => '2020-02-27 21:01:49',
            ),
            14 => 
            array (
                'id' => 15,
                'program_id' => 4,
                'bendahara' => 26,
                'kode_kegiatan' => '007',
                'nama_kegiatan' => 'Reviu DAK fisik',
                'created_at' => '2020-02-28 04:01:35',
                'updated_at' => '2020-02-27 21:01:35',
            ),
            15 => 
            array (
                'id' => 16,
                'program_id' => 4,
                'bendahara' => 25,
                'kode_kegiatan' => '008',
                'nama_kegiatan' => 'Monitoring dan evaluasi program strategis Gubernur',
                'created_at' => '2020-02-28 04:01:24',
                'updated_at' => '2020-02-27 21:01:24',
            ),
            16 => 
            array (
                'id' => 17,
                'program_id' => 5,
                'bendahara' => 21,
                'kode_kegiatan' => '002',
                'nama_kegiatan' => 'Pelaksanaan pemeriksaan terhadap kasus pengaduan masyarakat',
                'created_at' => '2020-02-28 04:01:00',
                'updated_at' => '2020-02-27 21:01:00',
            ),
            17 => 
            array (
                'id' => 18,
                'program_id' => 5,
                'bendahara' => 21,
                'kode_kegiatan' => '004',
                'nama_kegiatan' => 'Pelaksanaan tindak lanjut hasil pemeriksaan kasus pengaduan masyarakat',
                'created_at' => '2020-02-28 04:00:43',
                'updated_at' => '2020-02-27 21:00:43',
            ),
            18 => 
            array (
                'id' => 19,
                'program_id' => 5,
                'bendahara' => 25,
                'kode_kegiatan' => '006',
                'nama_kegiatan' => 'Pembinaan dan Evaluasi penyelenggaraan pemerintahan daerah di Kab/Kota',
                'created_at' => '2020-02-28 04:00:24',
                'updated_at' => '2020-02-27 21:00:24',
            ),
            19 => 
            array (
                'id' => 20,
                'program_id' => 5,
                'bendahara' => 21,
                'kode_kegiatan' => '008',
                'nama_kegiatan' => 'Pemutakhiran Data Tindak Lanjut Hasil Hasil Pemeriksaan APIP tingkat Nasional dan Daerah',
                'created_at' => '2020-02-28 04:00:06',
                'updated_at' => '2020-02-27 21:00:06',
            ),
            20 => 
            array (
                'id' => 21,
                'program_id' => 5,
                'bendahara' => 26,
                'kode_kegiatan' => '009',
                'nama_kegiatan' => 'Pengawasan penyelenggaraan pemerintahan daerah pada PD Provinsi',
                'created_at' => '2020-02-28 03:59:50',
                'updated_at' => '2020-02-27 20:59:50',
            ),
            21 => 
            array (
                'id' => 22,
                'program_id' => 5,
                'bendahara' => 25,
                'kode_kegiatan' => '013',
                'nama_kegiatan' => 'Pemutakhiran Data Tindak Lanjut Hasil Hasil Pemeriksaan BPK RI',
                'created_at' => '2020-02-28 03:59:28',
                'updated_at' => '2020-02-27 20:59:28',
            ),
        ));
        
        
    }
}