<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Akomodasi
 *
 * @package App\Models
 * @property int $id
 * @property int $kabkota_id
 * @property int $eselon_2
 * @property int $eselon_3
 * @property int $madya
 * @property int $eselon_4_gol_3_4
 * @property int $gol_1_2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kabkota $kabkota
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi searchKabkota($kabkota)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereEselon2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereEselon3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereEselon4Gol34($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereGol12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereKabkotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereMadya($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Akomodasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Akomodasi extends Model
{
	protected $table = 'akomodasi';
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
