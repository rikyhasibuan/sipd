<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $nip
 * @property string $password
 * @property int $level_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Level $level
 * @property-read \App\Models\Pegawai $pegawai
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchLevel($level)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchNotAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User searchUser($q)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    protected $table = 'user';
    protected $dates = ['created_at', 'updated_at'];

    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id');
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai', 'nip', 'nip');
    }

    public function scopeSearchUser($query, $q)
    {
        if ($q) return $query->where('nip', 'LIKE', '%' . $q . '%');
    }

    public function scopeSearchLevel($query, $level)
    {
        if ($level) return $query->where('level_id', '=', $level);
    }

    public function scopeSearchStatus($query, $status)
    {
        if ($status) return $query->where('status', '=', $status);
    }
    
    public function scopeSearchNotAdmin($query)
    {
        return $query->where('level_id', '!=', 1);
    }
}
