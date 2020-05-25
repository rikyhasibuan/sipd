<?php
namespace App\Libraries;

use Exception;

class Access
{
    function generateAccess($level) {
        try {
            $access = array();
            switch ($level) {
                case '1':
                    $access = ['write' => 1, 'update' => 1, 'delete' => 1, 'approval' => 1];
                    break;
                case '2':
                    $access = ['write' => 1, 'update' => 1, 'delete' => 0, 'approval' => 0];
                    break;
                case '3':
                case '4':
                case '5':
                    $access = ['write' => 0, 'update' => 0, 'delete' => 0, 'approval' => 1];
                    break;
            }
            return $access;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
