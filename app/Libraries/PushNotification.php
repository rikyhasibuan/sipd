<?php

namespace App\Libraries;

use App\Models\Token;

/**
 * Class PushNotification
 *
 * Wrapper for Push Notification
 *
 * @package Pengaduan\Libraries
 */
class PushNotification {
    
    /**
     * @var string
     */
    protected $serverKey = 'AAAA1OzeCCI:APA91bFErqJ73Vhu4Q1eRwaug2AYol4WBUTMil1IA2nAnbkOTMCgTlJ1CViUdo5ewumF_TWbTXdgWnHqrPJdCoNrx05o-w7dNA8tMJzvyTo2xd3LnurhyhY8joHb2tuQJPOS-MfVXBs_';
    
    /**
     * @return array
     */
    function getHeader() {
        return array('Authorization:key=' . $this->serverKey, 'Content-Type: application/json');                   
    }

    /**
     * sending notification to user targeted device
     * 
     * @param int $user
     * @param string $user_message
     * @return object $result
     */
    function notifyMessage($user, $user_message) {
        $header = self::getHeader();
        $token = Token::where('backuser_id', $user)->first();
        
        if (!empty($token)) {
            $message = ['title'=>'New Message', 'body'=>$user_message, 'icon'=>'', 'click_action'=>''];
            $payload = array('registration_ids' => $token->token, 'notification' => $message);
            
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch,CURLOPT_POST, true);
            curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($payload));
            curl_exec($ch);
            curl_close ($ch);
        }
    }
}