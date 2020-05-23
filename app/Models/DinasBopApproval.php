<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
