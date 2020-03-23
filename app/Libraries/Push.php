<?php

namespace App\Libraries;

use Pusher\Pusher;
use Exception;

class Push 
{
    private $app_id = '838262';
    private $app_key = '2160909eb1b0aa4c0659';
    private $app_secret = 'e0aa45cc6c8797c27088';
    private $app_cluster = 'ap1';
    private $app_tls = false;

    function singleWebNotification($nip, $kode) {
        try {
            $pusher = New Pusher($this->app_key, $this->app_secret, $this->app_id, ['cluster' => $this->app_cluster, 'useTLS' => $this->app_tls]);
            $pusher->trigger('konsultasiweb_'. $nip, 'web', $kode);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function multipleWebNotification($nip, $kode) {
        try {
            $pusher = new Pusher($this->app_key, $this->app_secret, $this->app_id, ['cluster' => $this->app_cluster, 'useTLS' => $this->app_tls]);
            $channel = array();
            foreach ($nip as $val) {
                array_push($channel, 'konsultasiweb_'. $val);
            }
            $pusher->trigger($channel, 'web', $kode);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function singleLangsungNotification($nip, $kode) {
        try {
            $pusher = new Pusher($this->app_key, $this->app_secret, $this->app_id, ['cluster' => $this->app_cluster, 'useTLS' => $this->app_tls]);
            $pusher->trigger('konsultasilangsung_' . $nip, 'langsung', $kode);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function multipleLangsungNotification($nip, $kode) {
        try {
            $pusher = new Pusher($this->app_key, $this->app_secret, $this->app_id, ['cluster' => $this->app_cluster, 'useTLS' => $this->app_tls]);
            $channel = array();
            foreach ($nip as $val) {
                array_push($channel, 'konsultasilangsung_' . $val);
            }
            $pusher->trigger($channel, 'langsung', $kode);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}