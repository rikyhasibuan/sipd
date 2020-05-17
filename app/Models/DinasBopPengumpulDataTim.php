<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasBopPengumpulDataTim extends Model
{
    protected $table = 'dinasbop_pengumpuldata_tim';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'tim' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }

    public function dinasboppengumpuldata()
    {
        return $this->belongsTo('App\Models\DinasBopPengumpulData', 'dinasbop_pengumpuldata_id');
    }
}
