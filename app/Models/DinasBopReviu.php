<?php
namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class DinasBopReviu extends Model
{
    protected $table = 'dinasbop_reviu';
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
