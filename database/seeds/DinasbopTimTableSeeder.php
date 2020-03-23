<?php

use Illuminate\Database\Seeder;

class DinasbopTimTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dinasbop_tim')->delete();
        
        \DB::table('dinasbop_tim')->insert(array (
            0 => 
            array (
                'id' => 1,
                'dinasbop_id' => 3,
                'irban_id' => 1,
                'nomor_sp' => '123456789',
                'tgl_sp' => '2020-03-07',
                'auditan' => 'Biro Hukum dan Hak Asasi Manusia Setda',
                'tim' => '{"driver": {"nip": "197108152008011001", "hari": 14, "nama": "DAHYAN", "biaya": 850000, "total": 11900000, "golongan": "II/c"}, "anggota": [{"nip": "196112031982031010", "hari": 14, "nama": "CUCU SUHADA, S.Sos, MM", "biaya": 1300000, "total": 18200000, "golongan": "IV/a"}, {"nip": "196002041983031014", "hari": 14, "nama": "RADEN KUNDRAT, S.Sos", "biaya": 1300000, "total": 18200000, "golongan": "IV/a"}, {"nip": "196202081992021002", "hari": 14, "nama": "DODY SOTANDI, S.H.", "biaya": 1300000, "total": 18200000, "golongan": "IV/a"}], "ketuatim": {"nip": "196612291990021001", "hari": 14, "nama": "ADE IMANSAH, A.Ks., M.Si", "biaya": 1400000, "total": 19600000, "golongan": "IV/b"}, "pengendaliteknis": {"nip": "196009151981031007", "hari": 14, "nama": "Drs. KARYONO, M.Si.", "biaya": 1500000, "total": 21000000, "golongan": "IV/b"}, "wakilpenanggungjawab": {"nip": "196203211993021001", "hari": 14, "nama": "Ir.RUDY", "biaya": 1600000, "total": 22400000, "golongan": "IV/c"}}',
                'lampiran' => 'lampiran_dinas/bop/kcsgf8fiYbGdbBQgBU3GcGjETdiEU5M91QnGBYh2.jpeg',
                'total_anggaran' => 129500000,
                'created_at' => '2020-03-07 12:24:40',
                'updated_at' => '2020-03-07 12:24:40',
            ),
        ));
        
        
    }
}