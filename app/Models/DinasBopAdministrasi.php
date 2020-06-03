<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasBopAdministrasi
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DinasBopAdministrasiTim[] $tim
 * @property-read int|null $tim_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereUntuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBopAdministrasi extends Model
{
    protected $table = 'dinasbop_administrasi';
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
        return $this->hasMany('App\Models\DinasBopAdministrasiTim', 'dinasbop_administrasi_id', 'id');
    }

}
