<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IrbanKabkota extends Model
{
    protected $table = 'irban_kabkota';
    protected $dates = ['created_at', 'updated_at'];

    public function kabkota()
    {
        return $this->belongsTo('App\Models\Kabkota', 'kabkota_id');
    }

    public function irban()
    {
        return $this->belongsTo('App\Models\Irban', 'irban_id');
    }
}
