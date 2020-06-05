<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
class DinasBopTest extends TestCase
{
    public function testGetData()
    {
        $this->get('api/dinasbop')->assertStatus(200)->assertJson(['total' => 1]);
    }

    public function testPostData()
    {
        $this->post('api/dinasbop')->assertStatus(200)->assertJson(['status' => 'ok']);
    }
}
