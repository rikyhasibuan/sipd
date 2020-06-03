<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasBopSupervisi
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereNomorSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereTglSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereTim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereTujuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopSupervisi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBopSupervisi extends Model
{
    protected $table = 'dinasbop_supervisi';
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
