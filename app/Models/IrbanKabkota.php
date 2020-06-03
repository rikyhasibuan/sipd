<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IrbanKabkota
 *
 * @property int $id
 * @property int $irban_id
 * @property int $kabkota_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Irban $irban
 * @property-read \App\Models\Kabkota $kabkota
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota whereIrbanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota whereKabkotaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota searchIrban($irban)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanKabkota searchKabkota($kabkota)
 */
class IrbanKabkota extends Model
{
    protected $table = 'irban_kabkota';
    protected $dates = ['created_at', 'updated_at'];

    public function kabkota()
    {
        return $this->belongsTo('App\Models\Kabkota', 'kabkota_id');
    }

    public function irban()
    {
        return $this->belongsTo('App\Models\Irban', 'irban_id');
    }

    public function scopeSearchKabkota($query, $kabkota) 
    {
        if ($kabkota != '') {
            return $query->where('kabkota_id', $kabkota);
        }
    }

    public function scopeSearchIrban($query, $irban)
    {
        if ($irban != '') {
            return $query->where('irban_id', $irban);
        }
    }
}
