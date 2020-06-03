<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasBopApproval
 *
 * @property int $id
 * @property int $dinasbop_id
 * @property string $tab
 * @property array $inspektur
 * @property array $sekretaris
 * @property array $kassubag
 * @property int $lock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasBop $dinasbop
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereDinasbopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereInspektur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereKassubag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereSekretaris($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasBopApproval whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasBopApproval extends Model
{
    protected $table = 'dinasbop_approval';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'inspektur' => 'array',
        'sekretaris' => 'array',
        'kassubag' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }
}
