<?php

namespace App\Http\Controllers;

use App\ConCurrent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['saveLog','maxCon']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function saveLog(Request $request)
    {
        date_default_timezone_set("Asia/seoul");
        $log = new ConCurrent();

        $log->value = $request->input('value');
        $log->created_at = Carbon::now();

        if ($log->save()){
            return $log->toArray();
        }
    }

    public function emptyLog()
    {
        ConCurrent::truncate();
    }

    public function maxCon(){

        $today = Carbon::today();

        $maxCon = ConCurrent::whereDate('created_at', $today)->max('value');

        $maxMonthCon = ConCurrent::whereMonth('created_at', $today->month)
            ->whereYear('created_at', $today->year)
            ->max('value');

        return response()->json([ 'max' => $maxCon, 'month' => $maxMonthCon ]);
    }
}
