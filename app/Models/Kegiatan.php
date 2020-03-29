<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Kegiatan
 *
 * @package App\Models
 * @property int $id
 * @property int|null $program_id
 * @property int|null $bendahara
 * @property string $kode_kegiatan
 * @property string $nama_kegiatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pegawai|null $pegawai
 * @property-read \App\Models\Program|null $program
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan searchBendahara($bendahara)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan searchKegiatan($q)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan searchProgram($program)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan whereBendahara($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan whereKodeKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan whereNamaKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Kegiatan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $dates = ['created_at', 'updated_at'];

    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id');
    }
    
    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'bendahara');
    }

    public function scopeSearchKegiatan($query, $q)
    {
        if ($q) {
            return $query->where('kode_kegiatan', 'LIKE', '%' . $q . '%')->orWhere('nama_kegiatan', 'LIKE', '%' . $q . '%');
        }
    }

    public function scopeSearchProgram($query, $program)
    {
        if ($program) {
            return $query->where('program_id', $program);
        }
    }
    
    public function scopeSearchBendahara($query, $bendahara)
    {
        if ($bendahara) {
            return $query->where('bendahara', $bendahara);
        }
    }
}
