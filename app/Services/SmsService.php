<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    private $api_url = 'http://46.151.210.31:8080/websmpp/websms';
    private $api_user;
    private $api_pass;
    private $api_sid;

    public function __construct()
    {
        $this->api_user = config('app.broadnet.ApiUser');
        $this->api_pass = config('app.broadnet.ApiPass');
        $this->api_sid = config('app.broadnet.ApiSid');
    }

    public function sms($phone, $otp)
    {
        $url = "$this->api_url?user=$this->api_user&pass=$this->api_pass&sid=$this->api_sid&mno=$phone&type=4&text=رمز التحقق: $otp&respformat=json";
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post($url);


        return ['message' => $response];
    }
}
