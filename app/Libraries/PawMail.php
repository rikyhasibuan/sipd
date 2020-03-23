<?php

namespace App\Libraries;

/**
 * Class Mail
 * Email Wrapper
 *
 * @package Pengaduan\Libraries
 */
class PawMail
{
    function sendActivationMail($user) {
        $payload =  [
                        'From'=>'connect@enigami.co.id',
                        'To'=>$user['email'], 
                        'TemplateAlias'=>'activation', 
                        'TemplateModel'=>
                                        [
                                            'id' => $user['id']
                                        ]
                    ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.postmarkapp.com/email/withTemplate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'X-Postmark-Server-Token: 8b8afcb8-9fda-4030-8c67-24c1758f5751';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function sendForgotPassword($user) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endPoint . '?act=forgotpassword');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($user));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        if ($server_output == "OK") {
            return true;
        } else {
            return false;
        }
    }
}
