<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Kabkota
 *
 * @property int $id
 * @property string $nama_kabkota
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kabkota newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kabkota newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kabkota query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kabkota whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kabkota whereNamaKabkota($value)
 * @mixin \Eloquent
 */
class Kabkota extends Model
{
    protected $table = 'kabkota';
    public $timestamps = false;
}
