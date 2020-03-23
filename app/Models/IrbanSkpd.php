<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IrbanSkpd extends Model
{
    protected $table = 'irban_skpd';
    protected $dates = ['created_at', 'updated_at'];

    public function skpd()
    {
        return $this->belongsTo('App\Models\Skpd', 'skpd_id');
    }

    public function irban()
    {
        return $this->belongsTo('App\Models\Irban', 'irban_id');
    }
}
