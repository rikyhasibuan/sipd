<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DinasRegularTim
 *
 * @package App\Models
 * @property int $id
 * @property int $dinasregular_id
 * @property int $pegawai_id
 * @property string $jabatan
 * @property int $uang_harian
 * @property int $durasi_harian
 * @property int $uang_akomodasi
 * @property int $durasi_akomodasi
 * @property int|null $total_biaya
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasRegular $dinasregular
 * @property-read \App\Models\Pegawai $pegawai
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereDinasregularId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereDurasiAkomodasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereDurasiHarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim wherePegawaiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereTotalBiaya($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereUangAkomodasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereUangHarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularTim whereUpdatedAt($value)
 * @mixin \Eloquent
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