<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
