<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Harian
 * @package App\Models
 */

class Harian extends Model
{
  protected $table = 'harian';
  protected $dates = ['created_at', 'updated_at'];

  public function kabkota()
  {
    return $this->belongsTo('App\Models\Kabkota', 'kabkota_id');
  }

  public function scopeSearchKabkota($query, $kabkota)
  {
  	if ($kabkota) {
  		return $query->where('kabkota_id', $kabkota);
  	}
  }
  
}
