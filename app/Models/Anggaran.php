<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Anggaran
 * @package App\Models
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