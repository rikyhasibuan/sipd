<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bbm
 *
 * @package App\Models
 * @property int $id
 * @property int $harga_perliter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HargaBbm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HargaBbm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HargaBbm query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HargaBbm whereHargaPerliter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HargaBbm whereId($value)
 * @mixin \Eloquent
 */

class HargaBbm extends Model
{
	protected $table = 'harga_bbm';
	public $timestamps = false;
}
