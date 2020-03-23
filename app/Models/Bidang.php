<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bidang
 * @package App\Models
 */
class Bidang extends Model
{
    protected $table = 'bidang';
    protected $dates = ['created_at', 'updated_at'];

    public function scopeSearchBidang($query, $q)
    {
        if ($q) {
            return $query->where('nama_bidang', 'LIKE', '%' . $q . '%');
        }
    }
}
