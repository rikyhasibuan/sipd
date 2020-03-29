<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Level
 *
 * @property int $id
 * @property string $nama_level
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Level whereNamaLevel($value)
 * @mixin \Eloquent
 */
class Level extends Model
{
    protected $table = 'level';
    public $timestamps = false;
}
