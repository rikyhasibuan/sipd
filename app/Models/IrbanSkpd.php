<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IrbanSkpd
 *
 * @property int $id
 * @property int $irban_id
 * @property int $skpd_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Irban $irban
 * @property-read \App\Models\Skpd $skpd
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd whereIrbanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd whereSkpdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IrbanSkpd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IrbanSkpd extends Model
{
    protected $table = 'irban_skpd';
    protected $dates = ['created_at', 'updated_at'];

    public function skpd()
    {
        return $this->belongsTo('App\Models\Skpd', 'skpd_id');
    }

    public function irban()
    {
        return $this->belongsTo('App\Models\Irban', 'irban_id');
    }

    public function scopeSearchSkpd($query, $skpd) 
    {
        if ($skpd != '') {
            return $query->where('skpd_id', $skpd);
        }
    }

    public function scopeSearchIrban($query, $irban)
    {
        if ($irban != '') {
            return $query->where('irban_id', $irban);
        }
    }
}
