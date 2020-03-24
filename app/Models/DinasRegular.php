<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DinasRegular
 * @package App\Models
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
}
