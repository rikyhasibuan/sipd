<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogAktifitas
 *
 * @property int $id
 * @property string $page
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas searchAkhirPeriode($end_date)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas searchAwalPeriode($start_date)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas searchPage($page)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LogAktifitas whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LogAktifitas extends Model {
  
  protected $table = 'log_aktifitas';

  public function scopeSearchPage($query, $page) {
    return $query->where('page', $page);
  }

  public function scopeSearchAwalPeriode($query, $start_date) {
    if ($start_date != '') {
      return $query->whereDate('created_at', '>=', $start_date);
    }
  }

  public function scopeSearchAkhirPeriode($query, $end_date) {
    if ($end_date != '') return $query->whereDate('created_at', '<=', $end_date);
  }
}
