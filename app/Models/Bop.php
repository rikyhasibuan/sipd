<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bop
 * @package App\Models
 */
class Bop extends Model
{
    protected $table = 'bop';
    protected $dates = ['created_at', 'updated_at'];

    public function scopeSearchJabatan($query, $pangkat)
    {
        if ($pangkat) {
            return $query->where('pangkat', $pangkat);
        }
    }
}
