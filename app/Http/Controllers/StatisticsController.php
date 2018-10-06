<?php

namespace App\Http\Controllers;

use App\ConCurrent;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;


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
            if (date('m', $time)==$month)
//                $list[]=date('Y-m-d-D', $time);
                $list[]=date('Y-m-d', $time);
        }

//        $data = ConCurrent::where('created_at', 'like', '2018-10-04%')->orderby('value','ase')->get()->first();
//
//        dd($data->value);

        foreach($list as $item) {
//            $data[] = ConCurrent::where('created_at', 'like', $item . '%')->orderby('value','ase')->get()->first();
//
//
            $data[] = DB::table('con_current')->where('created_at', 'like', $item.'%')->orderby('value','ase')->get()->first();
//
//
//
//
        }

//dd($data['3']->id);
        return view('statistics.index', compact( 'dateFrom', 'data', 'cnt', 'list'));
    }
}
