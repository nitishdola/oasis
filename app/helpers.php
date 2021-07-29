<?php // Code within app\Helpers\Helper.php

namespace App;

class Helper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }

    public static function sendSMS($mobile_no, $otp) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/v5/otp?authkey=317500AVsvLTjWd95e4052b0P1&template_id=5f83c5ca2e9faf05a3322815&mobile=91".$mobile_no."&invisible=1&otp=".$otp,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

    
    }
}