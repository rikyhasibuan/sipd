<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Kegiatan
 * @package App\Models
 */
class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $dates = ['created_at', 'updated_at'];

    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id');
    }
    
    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'bendahara');
    }

    public function scopeSearchKegiatan($query, $q)
    {
        if ($q) {
            return $query->where('kode_kegiatan', 'LIKE', '%' . $q . '%')->orWhere('nama_kegiatan', 'LIKE', '%' . $q . '%');
        }
    }

    public function scopeSearchProgram($query, $program)
    {
        if ($program) {
            return $query->where('program_id', $program);
        }
    }
    
    public function scopeSearchBendahara($query, $bendahara)
    {
        if ($bendahara) {
            return $query->where('bendahara', $bendahara);
        }
    }
}
