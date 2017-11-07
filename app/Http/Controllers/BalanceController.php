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


        $cdrs = Cdr::whereIn('src', $ext)->whereRaw('LENGTH(dst) != 4')->orderBy('calldate', 'desc')->paginate(15);

        $prices = Cdr::whereIn('src', $ext)->whereRaw('LENGTH(dst) != 4')->get();

        $cnt = Cdr::whereIn('src', $ext)->whereRaw('LENGTH(dst) != 4')->count();

        $total = 0;

        foreach ($prices as $price)
        {
            if(substr($price->dst,'0','2') === '01');
            {
                $total = $total + ceil($price->billsec/10)*6.8;
            }
            if(substr($price->dst, 0,2)==='86'){
                $total = $total + ceil($price->billsec/60)*22;
            }
            if((substr($price->dst, 0,3)==='070') || (substr($price->dst,0,3) === '050' )) {
                $total = $total + ceil($price->billsec/180)*45;
            }
            if((substr($price->dst, 0,2)!='01') && (substr($price->dst,0,2) != '86' ) && (substr($price->dst,0,3) != '070' ) && (substr($price->dst,0,3) != '050' )) {
                $total = $total + ceil($price->billsec/180)*32;
            }
        }

        return view('list.index')->withCdrs($cdrs)->withCnt($cnt)->withTotal($total);
    }



}
