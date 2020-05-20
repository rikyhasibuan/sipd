<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DinasBopAdministrasiTim extends Model
{
    protected $table = 'dinasbop_administrasi_tim';
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = ['tim' => 'array'];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }

    public function dinasbopadministrasi()
    {
        return $this->belongsTo('App\Models\DinasBopAdministrasi', 'dinasbop_administrasi_id');
    }
}
