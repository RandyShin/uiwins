<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cdr;
use DB;


class BalanceController extends Controller
{
    public function index()
    {

        $ext = [2200,2201,2202,2203,2204,2205,2206,2207,2208,2209,2210,2211,2212,2213,2214,2215,2216,2217,2218,2219,2220];

        $cdrs = Cdr::whereIn('src', $ext)->orderBy('calldate', 'desc')
            ->paginate(15);

        $cnt = Cdr::whereIn('src', $ext)->count();
        

        return view('list.index')->withCdrs($cdrs)->withCnt($cnt);
    }



}
