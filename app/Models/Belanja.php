<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Belanja
 *
 * @package App\Models
 */
class Belanja extends Model
{
    protected $table = 'belanja';
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan', 'kegiatan_id');
    }

    public function scopeSearchBelanja($query, $q)
    {
        if ($q) {
            return $query->where('kode_belanja', 'LIKE', '%' . $q . '%')->orWhere('nama_belanja', 'LIKE', '%' . $q . '%');
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
}
