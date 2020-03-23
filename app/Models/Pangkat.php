<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pangkat
 * @package App\Models
 */
class Pangkat extends Model
{
    protected $table = 'pangkat';
    protected $dates = ['created_at', 'updated_at'];
}
