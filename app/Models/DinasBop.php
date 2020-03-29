<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DinasBop
 *
 * @package App\Models
 * @property int $id
 * @property int $program_id
 * @property int $kegiatan_id
 * @property int $belanja_id
 * @property array|null $dasar
 * @property array|null $untuk
 * @property \Illuminate\Support\Carbon|null $dari
 * @property \Illuminate\Support\Carbon|null $sampai
 * @property int|null $total_anggaran
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Belanja $belanja
 * @property-read \App\Models\Irban $irban
 * @property-read \App\Models\Kegiatan $kegiatan
 * @property-read \App\Models\Program $program
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DinasBopTim[] $tim
 * @property-read int|null $tim_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop searchBelanja($belanja)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop searchKegiatan($kegiatan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop searchProgram($program)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereBelanjaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereDari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereDasar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereSampai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereUntuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBop extends Model
{
    protected $table = 'dinasbop';
    protected $dates = [
        'created_at',
        'updated_at',
        'dari',
        'sampai'
    ];
    protected $casts = [
        'dasar' => 'array',
        'untuk' => 'array'
    ];

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

    public function irban()
    {
        return $this->belongsTo('App\Models\Irban', 'irban_id');
    }

    public function tim()
    {
        return $this->hasMany('App\Models\DinasBopTim', 'dinasbop_id', 'id');
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

    public function scopeSearchTahun($query, $tahun)
    {
        if ($tahun != '') {
            return $query->whereYear('created_at', $tahun);
        }
    }
}
