<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Pangkat
 *
 * @package App\Models
 * @property int $id
 * @property string $nama_pangkat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat whereNamaPangkat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $golongan
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pangkat whereGolongan($value)
 */
class Pangkat extends Model
{
    protected $table = 'pangkat';
    protected $dates = ['created_at', 'updated_at'];
}
