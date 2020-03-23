<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IrbanPokja extends Model
{
    protected $table = 'irban_pokja';
    protected $dates = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'pegawai_id');
    }

    public function irban() 
    {
        return $this->belongsTo('App\Models\Irban', 'irban_id');
    }

    public function scopeSearchIrban($query, $irban)
    {
        if ($irban != '') {
            return $query->where('irban_id', $irban);
        }
    }

}
