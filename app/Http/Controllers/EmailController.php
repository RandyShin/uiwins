<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{
    public function send(Request $request)
    {

        $email = "randy@ziotes.com";
        $subject = "my subject";
        $body = "my body";


        $to_name = 'Randy Shin';
        $to_email = $email;
        $data = array('name'=>"name", "body" => $body);

        Mail::send('email.dailyreport', $data, function($message) use ($to_name, $to_email, $subject) {
            $message->to($to_email, $to_name)
                ->subject($subject);
            $message->from('bill.ziotes@gmail.com','ZioTes');
        });

        return back()->with('success', 'Email sent successfully!');
    }
}
