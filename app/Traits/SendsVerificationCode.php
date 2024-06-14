<?php

namespace App\Traits;

trait SendsVerificationCode
{
    protected $smsService;

    public function sendVerificationCode($phone, $verificationCode)
    {
        $twilioSid = env('TWILIO_SID');
        $twilioToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $twilio = new Client($twilioSid, $twilioToken);

        $message = $twilio->messages
            ->create($phone, // to
                [
                    'body' => "Your verification code is: $verificationCode",
                    'from' => $twilioNumber,
                ]
            );

        return $message; // Optionally return the Twilio message object for further processing
    }
}
