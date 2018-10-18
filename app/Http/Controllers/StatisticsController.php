<?php

namespace App\Http\Controllers;

use App\ConCurrent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Cdr;


class StatisticsController extends Controller
{
    public $dateForm;

    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $this->dateFrom   = \Request::get('dateFrom', Carbon::now()->format('Y-m-d'));
    }

    function index() {

        $dateFrom = $this->dateFrom;

        $month = substr($dateFrom, 5,2);
        $year = substr($dateFrom,0,4);

        $setDate = substr($dateFrom, 0,7);


        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time)==$month) {
                //                $list[]=date('Y-m-d-D', $time);
                $currentDate = date('Y-m-d', $time);

            $datelist[] = $currentDate;
              }
        }


        $max_value = DB::table('con_current')
            ->where('created_at', 'like', $setDate . '%')
            ->groupBy('date')
            ->selectRaw('DATE(created_at) as date,max(value) as value')
            ->get();

        $total_min = DB::table('cdr')
            ->where([
                ['calldate', 'like', $setDate . '%'],
                ['dstchannel', 'like', 'SIP/UnitedKingdom%']
            ])
            ->groupBy('date')
            ->selectRaw('DATE(calldate) as date, sum(billsec) as billsec')
            ->get();

        $data = [];
        foreach($datelist as $key => $datevalue){
            array_push($data, [
                'date' => $datevalue,
                'max' => isset($max_value[$key]) ? $max_value[$key]->value : '',
                'billsec' => isset($total_min[$key]) ? $total_min[$key]->billsec : ''
            ]);
        }
//        dd($datevalue);

        $currentMonth = substr($currentDate,0,7);

        $total = Cdr::where('calldate', 'like', $currentMonth . '%')->sum('billsec');

        return view('statistics.index', compact( 'dateFrom', 'total', 'cnt', 'data'));
    }
}
