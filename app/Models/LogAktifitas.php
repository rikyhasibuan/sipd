<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
