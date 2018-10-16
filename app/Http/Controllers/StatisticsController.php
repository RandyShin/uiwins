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

        $list=[];
        $month = substr($dateFrom, 5,2);
        $year = substr($dateFrom,0,4);


//        $val = ConCurrent::where('created_at', 'like', '2018-10-02%')->max('value');
//
//        dd($val);

        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time)==$month) {
                //                $list[]=date('Y-m-d-D', $time);
                $currentDate = date('Y-m-d', $time);
                $list[$currentDate] = new \stdClass();  // make object
                $list[$currentDate]->max_value = ConCurrent::where('created_at', 'like', $currentDate . '%')->max('value');
                $list[$currentDate]->total_min = Cdr::where('calldate', 'like', $currentDate . '%')->sum('billsec');
              }
        }

        $currentMonth = substr($currentDate,0,7);

        $total = Cdr::where('calldate', 'like', $currentMonth . '%')->sum('billsec');

        return view('statistics.index', compact( 'dateFrom', 'total', 'cnt', 'list'));
    }
}
