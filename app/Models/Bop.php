<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Bop
 *
 * @package App\Models
 * @property int $id
 * @property string $jabatan
 * @property int $biaya_per_hari
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop searchJabatan($pangkat)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop whereBiayaPerHari($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bop extends Model
{
    protected $table = 'bop';
    protected $dates = ['created_at', 'updated_at'];

    public function scopeSearchJabatan($query, $pangkat)
    {
        if ($pangkat) {
            return $query->where('pangkat', $pangkat);
        }
    }
}
