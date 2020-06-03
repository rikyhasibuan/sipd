<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasBopPengumpulData
 *
 * @property int $id
 * @property int $dinasbop_id
 * @property array|null $dasar
 * @property array|null $untuk
 * @property string|null $dari
 * @property string|null $sampai
 * @property int|null $total_anggaran
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasBop $dinasbop
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DinasBopPengumpulDataTim[] $tim
 * @property-read int|null $tim_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereUntuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBopPengumpulData extends Model
{
    protected $table = 'dinasbop_pengumpuldata';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'dasar' => 'array',
        'untuk' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }

    public function tim()
    {
        return $this->hasMany('App\Models\DinasBopPengumpulDataTim', 'dinasbop_pengumpuldata_id', 'id');
    }

}
