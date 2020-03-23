<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    protected $table = 'skpd';
    protected $dates = ['created_at', 'updated_at'];

    public function scopeSearchName($query, $q)
    {
        if ($q) {
            return $query->where('nama_skpd', 'LIKE', '%' . $q . '%')->orWhere('alamat', 'LIKE', '%' . $q . '%')->orWhere('kota', 'LIKE', '%' . $q . '%');
        }
    }
}
