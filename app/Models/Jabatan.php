<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Jabatan
 *
 * @package App\Models
 * @property int $id
 * @property string $nama_jabatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jabatan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jabatan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jabatan query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jabatan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jabatan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jabatan whereNamaJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Jabatan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $dates = ['created_at', 'updated_at'];
}
