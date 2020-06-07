<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\DinasBop;
use App\Models\Anggaran;

class DinasBopTest extends TestCase
{
    public function testGetData()
    {
        $dinasbop = DinasBop::all()->count();
        $this->get('api/dinasbop')->assertStatus(200)->assertJson(['total' => $dinasbop]);
    }

    /*public function testPostData()
    {
        $anggaran = Anggaran::where('bulan', 6)->get();
        $dari = 2;
        $sampai = 2;
        foreach ($anggaran as $a) {
            $dari = $sampai;
            $sampai = $sampai + 4;
            $dinasbop = [
                'program_id' => $a->program_id,
                'kegiatan_id' => $a->kegiatan_id,
                'belanja_id' => $a->belanja_id,
                'dasar' => [
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
                ],
                'untuk' => [
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                    'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
                ],
                'dari' => '2020-06-'. $dari,
                'sampai' => '2020-06-'. $sampai,
            ];
            $this->post('api/dinasbop', $dinasbop)->assertStatus(200)->assertJson(['status' => 'ok']);
            $dari = $dari + 1;
            $sampai = $sampai + 1;
        }

    }*/
}
