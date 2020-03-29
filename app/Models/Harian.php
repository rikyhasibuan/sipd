<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Harian
 *
 * @package App\Models
 * @property int $id
 * @property int $kabkota_id
 * @property int $gol_1
 * @property int $gol_2
 * @property int $gol_3
 * @property int $gol_4
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kabkota $kabkota
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian searchKabkota($kabkota)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereGol1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereGol2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereGol3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereGol4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereKabkotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Harian whereUpdatedAt($value)
 * @mixin \Eloquent
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
