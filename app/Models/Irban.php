<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Irban
 *
 * @property int $id
 * @property string $nama_irban
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Irban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Irban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Irban query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Irban whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Irban whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Irban whereNamaIrban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Irban whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Irban extends Model
{
    protected $table = 'irban';
    protected $dates = ['created_at', 'updated_at'];
}
