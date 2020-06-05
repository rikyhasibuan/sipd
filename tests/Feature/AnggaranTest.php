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
}
