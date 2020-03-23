<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DinasBopTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateData()
    {
        $payload = [
            'program_id' => 1,
            'kegiatan_id' => 1,
            'belanja_id' => 2,
            'dasar' => ["Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.", "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."],
            'untuk' => ["Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."],
            'dari' => '2020-03-01',
            'sampai' => '2020-03-05',
            'total_anggaran' => 0,
            'status' => 0,
            'created_at' => '2020-03-12 06:09:39',
            'updated_at' => '2020-03-11 23:09:39'
        ];

        $response = $this->json('POST', '/api/dinasbop', $payload);
        $response->dumpHeaders();
        $response->dump();
        $response->assertStatus(200);
        $response->assertJson(['status' => 'OK']);
        
    }
}
