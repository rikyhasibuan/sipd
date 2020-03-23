<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bbm
 * @package App\Models
 */

class Bbm extends Model
{
    protected $table = 'bbm';
    protected $dates = ['created_at', 'updated_at'];

    public function kabkota()
    {
        return $this->belongsTo('App\Models\Kabkota', 'kabkota_id');
    }
}
