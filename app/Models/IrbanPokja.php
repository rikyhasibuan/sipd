<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IrbanPokja
 *
 * @property int $id
 * @property int $irban_id
 * @property int $pegawai_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Irban $irban
 * @property-read \App\Models\Pegawai $pegawai
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja searchIrban($irban)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja whereIrbanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja wherePegawaiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanPokja whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IrbanPokja extends Model
{
    protected $table = 'irban_pokja';
    protected $dates = ['created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'pegawai_id');
    }

    public function irban() 
    {
        return $this->belongsTo('App\Models\Irban', 'irban_id');
    }

    public function scopeSearchIrban($query, $irban)
    {
        if ($irban != '') {
            return $query->where('irban_id', $irban);
        }
    }

}
