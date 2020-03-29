<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pegawai
 *
 * @package App\Models
 * @property int $id
 * @property string $nip
 * @property string $nama
 * @property string|null $golongan
 * @property string|null $pangkat
 * @property string|null $jabatan
 * @property string|null $eselon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai searchEselon($eselon)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai searchGolongan($golongan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai searchJabatan($jabatan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai searchNip($nip)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai searchPangkat($pangkat)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai searchPegawai($q)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereEselon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereGolongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai wherePangkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pegawai whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $dates = ['created_at', 'updated_at'];

    public function scopeSearchPegawai($query, $q)
    {
        if ($q) {
            return $query->where('nip', 'LIKE', '%' . $q . '%')->orWhere('nama', 'LIKE', '%' . $q . '%');
        }
    }
    
    public function scopeSearchNip($query, $nip)
    {
        if ($nip) {
            return $query->where('nip', $nip);
        }
    }

    public function scopeSearchPangkat($query, $pangkat)
    {
        if ($pangkat) {
            return $query->where('pangkat', $pangkat);
        }
    }

    public function scopeSearchGolongan($query, $golongan)
    {
        if ($golongan) {
            return $query->whereIn('golongan', $golongan);
        }
    }

    public function scopeSearchJabatan($query, $jabatan)
    {
        if ($jabatan) {
            return $query->where('jabatan', $jabatan);
        }
    }

    public function scopeSearchEselon($query, $eselon)
    {
        if ($eselon) {
            return $query->where('eselon', $eselon);
        }
    }

}
