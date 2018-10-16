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


        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time)==$month) {
                //                $list[]=date('Y-m-d-D', $time);

                $currentDate = date('Y-m-d', $time);
                $list[$currentDate] = ConCurrent::select('created_at','value','id')->where('created_at', 'like', $currentDate . '%')->Max('value');
                $totalmin[$currentDate] = Cdr::where('calldate', 'like', $currentDate . '%')->sum('billsec');
            }
        }

        $val = ConCurrent::where('created_at', 'like', '2018-10-02')->max('value');

        dd($val);

        return view('statistics.index', compact( 'dateFrom', 'data', 'cnt', 'list'));
    }
}
