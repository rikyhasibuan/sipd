<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Skpd
 *
 * @property int $id
 * @property string $nama_skpd
 * @property string|null $alamat
 * @property string|null $kota
 * @property string|null $kontak
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd searchName($q)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd whereKontak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd whereKota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd whereNamaSkpd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Skpd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Skpd extends Model
{
    protected $table = 'skpd';
    protected $dates = ['created_at', 'updated_at'];

    public function scopeSearchName($query, $q)
    {
        if ($q) {
            return $query->where('nama_skpd', 'LIKE', '%' . $q . '%')->orWhere('alamat', 'LIKE', '%' . $q . '%')->orWhere('kota', 'LIKE', '%' . $q . '%');
        }
    }
}
