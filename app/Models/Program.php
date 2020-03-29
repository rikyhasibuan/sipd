<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pegawai
 *
 * @package App\Models
 * @property int $id
 * @property string $kode_program
 * @property string $nama_program
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program searchProgram($q)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereKodeProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereNamaProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereUpdatedAt($value)
 * @mixin \Eloquent
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
