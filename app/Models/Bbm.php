<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bbm
 *
 * @package App\Models
 * @property int $id
 * @property int $kabkota_id
 * @property string $liter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kabkota $kabkota
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm whereKabkotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm whereLiter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bbm whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Bbm extends Model
{
    protected $table = 'bbm';
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
