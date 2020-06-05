<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\DinasBop;
class DinasBopTest extends TestCase
{
    public function testGetData()
    {
        $dinasbop = DinasBop::all()->count();
        $this->get('api/dinasbop')->assertStatus(200)->assertJson(['total' => $dinasbop]);
    }

    /* public function testPostData()
    {
        $this->post('api/dinasbop')->assertStatus(200)->assertJson(['status' => 'ok']);
    } */
}
