<?php

namespace App\Http\Controllers;

use App\ConCurrent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Cdr;
use Auth;


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


        if (Auth::user()->name === 'uiwins') {
            for( $m=0; $m<=4; $m++)  //number of month
            {
                $monthly   = date("Y-m", mktime(0, 0, 0, intval(date('m'))-$m, intval(date('d')), intval(date('Y'))  ));
                $monthlydata[] = $monthly;
            }
            $monthlyvalue = [];
        }else{
            for( $m=0; $m<=6; $m++)  //number of month
            {
                $monthly   = date("Y-m", mktime(0, 0, 0, intval(date('m'))-$m, intval(date('d')), intval(date('Y'))  ));
                $monthlydata[] = $monthly;
            }
            $monthlyvalue = [];
        }



        foreach( $monthlydata as $item ) {

            if ( Auth::user()->name === 'admin') {
                $monthlydata = DB::table('cdr')
                    ->where([
                        ['calldate', 'like', $item . '%']
                    ])
                    ->selectRaw('DATE(calldate) as date, sum(billsec) as billsec')
                    ->first();

                $monthlyvalue[] = $monthlydata;
            }
            elseif (Auth::user()->name === 'uiwins') {  //show only 40 channels(benjamin request)
                $monthlydata = DB::table('cdr')
                    ->where([
                        ['calldate', 'like', $item . '%'],
                        ['dstchannel', 'like', 'SIP/UnitedKingdom%'],
                    ])
                    ->where(function ($query) {
                        $query->orWhere('did','LIKE','02849115%')
                            ->orWhere('did','LIKE','02849116%')
                            ->orWhere('did','LIKE','02849119%');
                    })
                    ->selectRaw('DATE(calldate) as date, sum(billsec) as billsec')
                    ->first();

                $monthlyvalue[] = $monthlydata;
            }
            else{
                $monthlydata = DB::table('cdr')
                    ->where([
                        ['calldate', 'like', $item . '%'],
                        ['dstchannel', 'like', 'SIP/UnitedKingdom%']
                    ])
                    ->selectRaw('DATE(calldate) as date, sum(billsec) as billsec')
                    ->first();

                $monthlyvalue[] = $monthlydata;
            }
        }

//dd($monthlyvalue);

        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time)==$month) {
//                $list[]=date('Y-m-d-D', $time);
                $currentDate = date('Y-m-d(D)', $time);

            $datelist[] = $currentDate;
              }
        }


        $max_value = DB::table('con_current')
            ->where('created_at', 'like', $setDate . '%')
            ->groupBy('date')
            ->selectRaw('DATE(created_at) as date,max(value) as value')
            ->get();

        if (Auth::user()->name === 'uiwins'){
            $total_min = DB::table('cdr')
                ->where([
                    ['calldate', 'like', $setDate . '%'],
                    ['dstchannel', 'like', 'SIP/UnitedKingdom%']
                ])
                ->where(function ($query) {
                    $query->orWhere('did','LIKE','02849115%')
                        ->orWhere('did','LIKE','02849116%')
                        ->orWhere('did','LIKE','02849119%');
                })
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
        }else{
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
        }

//        dd($datevalue);

        $currentMonth = substr($currentDate,0,7);

        $total = Cdr::where('calldate', 'like', $currentMonth . '%')
                    ->where('dstchannel', 'like', 'SIP/UnitedKingdom%')
                    ->sum('billsec');

        return view('statistics.index', compact( 'dateFrom', 'total', 'cnt', 'data', 'monthlyvalue'));
    }
}
