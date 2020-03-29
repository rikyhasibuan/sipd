<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Anggaran
 *
 * @package App\Models
 * @property int $id
 * @property int $program_id
 * @property int $kegiatan_id
 * @property int $belanja_id
 * @property int $jumlah
 * @property int $bulan
 * @property string $tahun
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Belanja $belanja
 * @property-read \App\Models\Kegiatan $kegiatan
 * @property-read \App\Models\Program $program
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran searchBelanja($belanja)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran searchBulan($bulan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran searchKegiatan($kegiatan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran searchProgram($program)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran searchTahun($tahun)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereBelanjaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Anggaran whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Anggaran extends Model
{
  protected $table = 'anggaran';
  protected $dates = ['created_at', 'updated_at'];

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

  public function scopeSearchBulan($query, $bulan)
  {
    if ($bulan) {
      return $query->where('bulan', $bulan);
    }
  }

  public function scopeSearchTahun($query, $tahun)
  {
    if ($tahun) {
      return $query->where('tahun', $tahun);
    }
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
}