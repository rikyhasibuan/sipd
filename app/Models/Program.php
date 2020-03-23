<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pegawai
 * @package App\Models
 */

class Program extends Model
{
  protected $table = 'program';
  protected $dates = ['created_at', 'updated_at'];

  public function scopeSearchProgram($query, $q)
  {
    if ($q) {
    	return $query->where('kode_program', 'LIKE', '%' . $q . '%')->orWhere('nama_program', 'LIKE', '%' . $q . '%');
    }
  }
}
