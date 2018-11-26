<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Cdr;
use DB;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        //get today data
//        $currentMonth = substr($currentDate,0,7);
        $today =date('Y-m-d',strtotime("-1 days"));


        $todaydata = DB::table('cdr')
            ->where([
                ['calldate', 'like',  $today . '%'],
                ['dstchannel', 'like', 'SIP/UnitedKingdom%']
            ])
            ->selectRaw('DATE(calldate) as date, sum(billsec) as billsec')
            ->first();



        //end get data

        $email = "randy@ziotes.com";
        $subject = "my subject";
        $body = $todaydata;


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
