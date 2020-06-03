<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasBopAdministrasiTim
 *
 * @property int $id
 * @property int $dinasbop_id
 * @property int $dinasbop_administrasi_id
 * @property string $nomor_sp
 * @property string $tgl_sp
 * @property string $auditan
 * @property array $tim
 * @property int|null $total_anggaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasBop $dinasbop
 * @property-read \App\Models\DinasBopAdministrasi $dinasbopadministrasi
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereAuditan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereDinasbopAdministrasiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereNomorSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereTglSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereTim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopAdministrasiTim whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBopAdministrasiTim extends Model
{
    protected $table = 'dinasbop_administrasi_tim';
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = ['tim' => 'array'];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }

    public function dinasbopadministrasi()
    {
        return $this->belongsTo('App\Models\DinasBopAdministrasi', 'dinasbop_administrasi_id');
    }
}
