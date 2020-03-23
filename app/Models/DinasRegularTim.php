<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DinasRegularTim
 * @package App\Models
 */

class DinasRegularTim extends Model {

  protected $table = 'dinasregular_tim';
  protected $dates = ['created_at', 'updated_at'];

  public function dinasregular() {
    return $this->belongsTo('App\Models\DinasRegular', 'dinasregular_id');
  }

  public function pegawai() {
      return $this->belongsTo('App\Models\Pegawai', 'id', 'pegawai_id');
  }
}