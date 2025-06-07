<?php

namespace App\Services;

class SmsService
{

     public static function send(string $to, string $message, string $campaign = 'OrderUpdates')
    {
        $ch = curl_init();

        // Load from env for security
        $url = 'https://api.afromessage.com/api/send';
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJpZGVudGlmaWVyIjoiSHUzcFdXNHYwWmdVbU5xN2lVNXhYbWlnTEhnSEtvaHkiLCJleHAiOjE5MDQyOTkyMDIsImlhdCI6MTc0NjUzMjgwMiwianRpIjoiYjJhZTkwZmYtNGQ0Mi00NTljLWE0ZmMtMmY2OTMwNDMyNzFhIn0.pA0SxwqsaC47m-aHK7Fc2owllvBvE8DlQC3QX-tyZ1E';
        $from = 'e80ad9d8-adf3-463f-80f4-7c4b39f7f164';
        $sender = 'EASY';
        $callback = env('AFRO_SMS_CALLBACK', null);

        // Encode message
        $message = curl_escape($ch, $message);

        // Build full request URL
        $fullUrl = $url . '?from=' . $from . '&sender=' . $sender . '&to=' . $to . '&message=' . $message;
        if ($callback) {
            $fullUrl .= '&callback=' . $callback;
        }

        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // Set headers
        $headers = [
            'Authorization: Bearer ' . $token,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute and handle response
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            throw new \Exception('SMS Error: ' . curl_error($ch));
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            $data = json_decode($result, true);
            return $data['acknowledge'] === 'success';
        }

        return false;
    }
}