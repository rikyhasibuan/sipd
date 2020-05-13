<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasBopSupervisi extends Model
{
    protected $table = 'dinasbop_supervisi';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'tim' => 'array',
        'dasar' => 'array',
        'tujuan' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }
}
