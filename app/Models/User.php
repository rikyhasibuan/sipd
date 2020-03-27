<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
