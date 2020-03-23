<?php
namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DinasBopTim
 *
 * @package App\Models
 */
class DinasBopTim extends Model
{
    protected $table = 'dinasbop_tim';
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'tim' => 'array'
    ];

    public function dinasbop()
    {
        return $this->belongsTo('App\Models\DinasBop', 'dinasbop_id');
    }

    public function getLampiranAttribute($value) 
    {
        return Storage::url($value);
    }
}
