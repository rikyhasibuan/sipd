<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasBopPengumpulDataTim
 *
 * @property int $id
 * @property int $dinasbop_id
 * @property int $dinasbop_pengumpuldata_id
 * @property string $nomor_sp
 * @property string $tgl_sp
 * @property string $auditan
 * @property array $tim
 * @property int|null $total_anggaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasBop $dinasbop
 * @property-read \App\Models\DinasBopPengumpulData $dinasboppengumpuldata
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereAuditan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereDinasbopPengumpuldataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereNomorSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereTglSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereTim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopPengumpulDataTim whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBopPengumpulDataTim extends Model
{
    protected $table = 'dinasbop_pengumpuldata_tim';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'tim' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }

    public function dinasboppengumpuldata()
    {
        return $this->belongsTo('App\Models\DinasBopPengumpulData', 'dinasbop_pengumpuldata_id');
    }
}
