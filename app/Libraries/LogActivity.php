<?php


namespace App\Libraries;

use Exception;
use App\Models\LogActivity as Log;
class LogActivity
{
  function generateLog($payload) {
    try {
      $log = new Log();
      $log->channel = 'pengaduan';
      $log->message = $payload['text'];
      $log->created_at = date('Y-m-d H:i:s');
      if($log->save()) {
        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      return $e->getMessage();
    }
  }
}
