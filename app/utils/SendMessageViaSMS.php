<?php

namespace App\Utils;

use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

class SendMessageViaSMS
{
    private $baseUrl;
    private $apiKey;
    private $api;

    public function __construct()
    {
        $this->baseUrl = "https://qyxygw.api.infobip.com";
        $this->apiKey = "bef7a48e44e9c8eb23e0a27ebd211784-3175224a-3d8d-42c5-bd4b-bf4fc4b02d64";
        $configuration = new Configuration(host: $this->baseUrl, apiKey: $this->apiKey);
        $this->api = new SmsApi(config: $configuration);
    }

    public function sendSMS($number, $message)
    {
        $destination = new SmsDestination(to: $number);

        $message = new SmsTextualMessage(
            destinations: [$destination],
            text: $message
        );

        $request = new SmsAdvancedTextualRequest(
            messages: [$message]
        );

        $response = $this->api->sendSmsMessage($request);
        return $response->getMessages()[0]->getStatus()->getGroupName() === "PENDING";
    }

    public function saveOTP($phoneNumber, $otp)
    {
        $_SESSION[$phoneNumber] = $otp;
    }

    public function getOTP($phoneNumber)
    {
        return $_SESSION[$phoneNumber] ?? null;
    }

    public function verifyOTP($phoneNumber, $otp)
    {
        $otpSaved = $this->getOTP($phoneNumber);
        return $otpSaved == $otp;
    }

    public function generateOTP($length = 6)
    {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= mt_rand(0, 9); // Tạo ngẫu nhiên một chữ số từ 0 đến 9 và thêm vào chuỗi OTP
        }
        return $otp;
    }
}
