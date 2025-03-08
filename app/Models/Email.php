<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

   
    public static function sendSms($message, $receiver)
    {
        $ch = curl_init();
        $url = 'https://api.afromessage.com/api/send';
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJpZGVudGlmaWVyIjoiM3hLS3NyYTZweHRUUTFwbm5TU21hb3paRHNhbzZ6SDMiLCJleHAiOjE4NTgwOTIyNDEsImlhdCI6MTcwMDIzOTQ0MSwianRpIjoiYzZiZDZlNjEtZGFiMi00NzNiLWI1NzgtNGIzNDEyY2JjOTVjIn0._ks2xvuFvI9VFETRCjTl4W23aENf4wlgxE3LPJxV7D0';
        $from = 'e80ad9d8-adf3-463f-80f4-7c4b39f7f164';
        $sender = '9786';
        $message = curl_escape($ch, $message);
        $callback = 'YOUR_CALLBACK';
        // dd($message);

        curl_setopt($ch, CURLOPT_URL, $url . '?from=' . $from . '&sender=' . $sender . '&to=' . $receiver . '&message=' . $message . '&callback=' . $callback);
        // ... (other cURL options and headers)
        $headers = array();
        $headers[] = 'Authorization: Bearer '.$token;
        // dd($headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        // Handle response
        if (curl_errno($ch)) {
            // Handle cURL error
            \Log::error('SMS sending failed: ' . curl_error($ch));
        } else {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            switch ($http_code) {
                case 200:
                    $data = json_decode($result, true);
                    // dd($data);
                    if (is_array($data) && isset($data['acknowledge']) && $data['acknowledge'] == 'success') {
                        \Log::info('SMS sent successfully.');

                    } else {
                        \Log::error('SMS sending failed: API failure');
                    }
                    break;
                default:
                    \Log::error('SMS sending failed: Other HTTP Code - ' . $http_code);
            }
        }

        curl_close($ch);
    }
}
