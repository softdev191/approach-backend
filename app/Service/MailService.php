<?php


namespace App\Service;


use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService extends Mailable
{
    public function __construct()
    {

    }

    public function sendMail()
    {
        try {

            //if($credentials['email_address']){
                $credentials = "";
                $html = 'emails.dynamic';

                Mail::send(['$html' => '$html'], ['content' => "<p>Test Email </p>"], function ($message) use($credentials) {
                    $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $message->to(trim('pnglnndummy@gmail.com'));
                    $message->subject("Test SES");
                });
                Log::info('Sending TO :: ' . $credentials['email_address']);
//                $this->log($credentials, [
//                    'response_status' => 200,
//                    'response' => 'Broadcast Email Sent.'
//                ]);
                return true;
           // }
           // return false;
        } catch (\Exception $e) {
          dd($e->getMessage());
            return false;
        }
    }
}
