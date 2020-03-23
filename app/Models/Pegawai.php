<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pegawai
 * @package App\Models
 */
class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $dates = ['created_at', 'updated_at'];

    public function scopeSearchPegawai($query, $q)
    {
        if ($q) {
            return $query->where('nip', 'LIKE', '%' . $q . '%')->orWhere('nama', 'LIKE', '%' . $q . '%');
        }
    }
    
    public function scopeSearchNip($query, $nip)
    {
        if ($nip) {
            return $query->where('nip', $nip);
        }
    }

    public function scopeSearchPangkat($query, $pangkat)
    {
        if ($pangkat) {
            return $query->where('pangkat', $pangkat);
        }
    }

    public function scopeSearchGolongan($query, $golongan)
    {
        if ($golongan) {
            return $query->whereIn('golongan', $golongan);
        }
    }

    public function scopeSearchJabatan($query, $jabatan)
    {
        if ($jabatan) {
            return $query->where('jabatan', $jabatan);
        }
    }

    public function scopeSearchEselon($query, $eselon)
    {
        if ($eselon) {
            return $query->where('eselon', $eselon);
        }
    }

}
