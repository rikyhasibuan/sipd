<?php

namespace Tests\Feature;

use App\Models\Anggaran;
use App\Models\DinasRegular;
use App\Models\Pegawai;
use Faker\Factory as Faker;
use Tests\TestCase;

class DinasRegularTest extends TestCase
{

    public function testGetData()
    {
        $dinasreguler = DinasRegular::all()->count();
        $this->get('api/dinasregular')->assertStatus(200)->assertJson(['total' => $dinasreguler]);
    }

    public function testPostData()
    {
        $faker = Faker::create('id_ID');
        $anggaran = Anggaran::where('bulan', 6)->get();
        $dari = 1;
        $sampai = 1;
        foreach ($anggaran as $a) {
            $anggota = [];
            $pegawai = Pegawai::all()->random(5);
            foreach ($pegawai as $p) {
                array_push($anggota, ['key'=> $p->nip, 'label'=>$p->nip]);
            }

            $dari = $sampai;
            $sampai = $sampai + 5;
            $dinasreguler = [
                'program_id' => $a->program_id,
                'kegiatan_id' => $a->kegiatan_id,
                'belanja_id' => $a->belanja_id,
                'dasar' => [$faker->text, $faker->text, $faker->text],
                'untuk' => [$faker->text, $faker->text, $faker->text],
                'nomor_sp' => $faker->numberBetween(100000, 200000),
                'tgl_sp' => '2020-06-'. $dari,
                'dari' => '2020-06-'. $dari,
                'sampai' => '2020-06-'. $sampai,
                'auditan' => 'Kabupaten Garut',
                'tim' => $anggota
            ];
            $this->post('api/dinasregular', $dinasreguler)->assertStatus(200)->assertJson(['status' => 'ok']);
            $dari = $dari + 1;
            $sampai = $sampai + 1;
        }

    }
}
