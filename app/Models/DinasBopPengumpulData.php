<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasBopPengumpulData extends Model
{
    protected $table = 'dinasbop_pengumpuldata';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'dasar' => 'array',
        'untuk' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }

    public function tim()
    {
        return $this->hasMany('App\Models\DinasBopPengumpulDataTim', 'dinasbop_pengumpuldata_id', 'id');
    }

}
