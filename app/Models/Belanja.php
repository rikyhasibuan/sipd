<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Belanja
 *
 * @package App\Models
 * @property int $id
 * @property int $program_id
 * @property int $kegiatan_id
 * @property string $kode_belanja
 * @property string $nama_belanja
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kegiatan $kegiatan
 * @property-read \App\Models\Program $program
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja searchBelanja($q)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja searchKegiatan($kegiatan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja searchProgram($program)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja whereKegiatanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja whereKodeBelanja($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja whereNamaBelanja($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Belanja whereUpdatedAt($value)
 * @mixin \Eloquent
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
