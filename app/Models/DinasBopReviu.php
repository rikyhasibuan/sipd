<?php
namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasBopReviu
 *
 * @property int $id
 * @property int $dinasbop_id
 * @property string $nomor_sp
 * @property string $tgl_sp
 * @property string $dari
 * @property string $sampai
 * @property array $dasar
 * @property array $tujuan
 * @property array $tim
 * @property int|null $total_anggaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasBop $dinasbop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereNomorSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereTglSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereTim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereTujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopReviu whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBopReviu extends Model
{
    protected $table = 'dinasbop_reviu';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'tim' => 'array',
        'dasar' => 'array',
        'tujuan' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }
}
