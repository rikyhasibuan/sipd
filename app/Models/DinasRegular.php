<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasRegular
 *
 * @property int $id
 * @property int $program_id
 * @property int $kegiatan_id
 * @property int|null $belanja_id
 * @property string|null $nomor_sp
 * @property string|null $tgl_sp
 * @property array|null $dasar
 * @property array|null $untuk
 * @property string|null $auditan
 * @property \Illuminate\Support\Carbon|null $dari
 * @property \Illuminate\Support\Carbon|null $sampai
 * @property int|null $lama_inap
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\DinasRegularTim[] $tim
 * @property int|null $total_harian
 * @property int|null $total_akomodasi
 * @property array|null $total_transportasi
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Belanja|null $belanja
 * @property-read \App\Models\Kegiatan $kegiatan
 * @property-read \App\Models\Program $program
 * @property-read int|null $tim_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular searchBelanja($belanja)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular searchBulan($bulan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular searchKegiatan($kegiatan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular searchProgram($program)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular searchTahun($tahun)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereAuditan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereBelanjaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereLamaInap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereNomorSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereTglSp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereTim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereTotalAkomodasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereTotalHarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereTotalTransportasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereUntuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegular whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasRegular extends Model
{
    protected $table = 'dinasregular';
    protected $dates = ['created_at', 'updated_at', 'dari', 'sampai'];
    protected $casts = ['dasar' => 'array','untuk' => 'array', 'tim' => 'array', 'total_transportasi' => 'array'];

    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan', 'kegiatan_id');
    }

    public function belanja()
    {
        return $this->belongsTo('App\Models\Belanja', 'belanja_id');
    }

    public function tim()
    {
        return $this->hasMany('App\Models\DinasRegularTim','dinasregular_id','id');
    }

    public function scopeSearchProgram($query, $program)
    {
        if ($program) {
            return $query->where('program_id', $program);
        }
    }

    public function scopeSearchKegiatan($query, $kegiatan)
    {
        if ($kegiatan) {
            return $query->where('kegiatan_id', $kegiatan);
        }
    }

    public function scopeSearchBelanja($query, $belanja)
    {
        if ($belanja) {
            return $query->where('belanja_id', $belanja);
        }
    }

    public function scopeSearchBulan($query, $bulan)
    {
        if ($bulan != '') {
            return $query->whereMonth('created_at', $bulan);
        }
    }

    public function scopeSearchToBulan($query, $bulan)
    {
        if ($bulan != '') {
            return $query->whereMonth('created_at','<=', $bulan);
        }
    }

    public function scopeSearchTahun($query, $tahun)
    {
        if ($tahun != '') {
            return $query->whereYear('created_at', $tahun);
        }
    }
}
