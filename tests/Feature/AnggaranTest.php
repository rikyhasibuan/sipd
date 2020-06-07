<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Belanja;
use App\Models\Anggaran;
use Tests\TestCase;

class AnggaranTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetData()
    {
        $anggaran = Anggaran::all()->count();
        $this->get('api/anggaran')->assertStatus(200)->assertJson(['total' => $anggaran]);
    }

    /*public function testPostData()
    {
        $program = Program::all();
        $anggaran = [];
        foreach ($program as $p) {
            $kegiatan = Kegiatan::where('program_id', $p->id)->get();
            foreach ($kegiatan as $k) {
                $belanja = Belanja::where('kegiatan_id', $k->id)->where('program_id', $k->program_id)->get();
                foreach ($belanja as $b) {
                    for ($bulan=1; $bulan <= 12; $bulan++) {
                        $anggaran = [
                            'program_id' => $b->program_id,
                            'kegiatan_id' => $b->kegiatan_id,
                            'belanja_id' => $b->id,
                            'jumlah' => 100000000,
                            'bulan' => $bulan,
                            'tahun' => date('Y')
                        ];
                        $this->post('api/anggaran', $anggaran);
                    }
                }
            }
        }
    }*/
}
