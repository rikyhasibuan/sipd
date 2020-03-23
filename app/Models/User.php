<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @param $query
     * @param $q
     * @return mixed
     */
    public function scopeSearchUser($query, $q) {
        if ($q) return $query->where('nama', 'LIKE', '%' . $q . '%')->orWhere('nip', 'LIKE', '%' . $q . '%');
    }

    /**
     * @param $query
     * @param $level
     * @return mixedusername
     */
    public function scopeSearchLevel($query, $level) {
        if ($level) return $query->where('level_id', '=', $level);
    }
}
