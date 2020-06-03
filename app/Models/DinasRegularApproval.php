<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DinasRegularApproval
 *
 * @property int $id
 * @property int $dinasregular_id
 * @property array $inspektur
 * @property array $sekretaris
 * @property array $kassubag
 * @property int $lock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DinasRegular $dinasregular
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereDinasregularId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereInspektur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereKassubag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereSekretaris($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DinasRegularApproval whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DinasRegularApproval extends Model
{
    protected $table = 'dinasregular_approval';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'inspektur' => 'array',
        'sekretaris' => 'array',
        'kassubag' => 'array'
    ];

    public function dinasregular()
    {
        return $this->belongsTo('App\Models\DinasRegular', 'dinasregular_id');
    }
}
