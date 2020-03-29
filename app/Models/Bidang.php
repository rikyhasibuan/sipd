<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bidang
 *
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bidang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bidang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bidang query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bidang searchBidang($q)
 * @mixin \Eloquent
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
