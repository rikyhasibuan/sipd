<?php
namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DinasBopTim
 *
 * @package App\Models
 * @property int $id
 * @property int $dinasbop_id
 * @property int $irban_id
 * @property string $nomor_sp
 * @property string $tgl_sp
 * @property string $auditan
 * @property array $tim
 * @property string|null $lampiran
 * @property int|null $total_anggaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasBop $dinasbop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereAuditan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereIrbanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereLampiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereNomorSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereTglSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereTim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopTim whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property array $dasar
 * @property array|null $tujuan
 * @property string|null $dari
 * @property string|null $sampai
 * @property array $sekretaris
 * @property int|null $total
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSekretaris whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSekretaris whereDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSekretaris whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSekretaris whereSekretaris($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSekretaris whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSekretaris whereTujuan($value)
 */
class DinasBopSekretaris extends Model
{
    protected $table = 'dinasbop_sekretaris';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'sekretaris' => 'array',
        'dasar' => 'array',
        'tujuan' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }
}
