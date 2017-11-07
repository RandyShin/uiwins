<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cdr;
use DB;
use Excel;


class BalanceController extends Controller
{

    public function index()
    {

        // get date from and to
        $dateFrom   = \Request::get('dateFrom');
        $dateTo     = \Request::get('dateTo');
        //end


        echo $dateFrom;
 echo $dateTo;

        $cdrs = Cdr::where('dstchannel', 'like', 'SIP/SMI%')
            ->whereRaw('LENGTH(dst) != 4')
            ->where('calldate','>=', $dateFrom . ' 00:00:00')
            ->where('calldate','<=', $dateTo . ' 23:59:59')
            ->orderBy('calldate', 'desc')
            ->paginate(15);

        $prices = Cdr::where('dstchannel', 'like', 'SIP/SMI%')
            ->whereRaw('LENGTH(dst) != 4')
            ->get();

        $cnt = Cdr::where('dstchannel', 'like', 'SIP/SMI%')
            ->whereRaw('LENGTH(dst) != 4')
            ->where('calldate','>=', $dateFrom . ' 00:00:00')
            ->where('calldate','<=', $dateTo . ' 23:59:59')
            ->count();

        //Excel export
        Excel::create('test');



        // get total price result
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
        // get total price result


        return view('list.index')->withCdrs($cdrs)->withCnt($cnt)->withTotal($total);
    }

        public function excel()
        {

            // get date from and to
//            $dateFrom   = \Request::get('dateFrom');
//            $dateTo     = \Request::get('dateTo');
            //end



            $cdrs = Cdr::select('src','dst','disposition','duration')
                ->where('dstchannel', 'like', 'SIP/SMI%')
                ->whereRaw('LENGTH(dst) != 4')
//                ->where('calldate','>=', $dateFrom . ' 00:00:00')
//                ->where('calldate','<=', $dateTo . ' 23:59:59')
                ->get();




//            $cdrs = Cdr::select('calldate', 'src', 'dst')->limit(50)->get();


            Excel::create('cdr', function($excel) use($cdrs) {
                $excel->sheet('Sheet', function($sheet) use($cdrs) {
                    $sheet->fromArray($cdrs);
                });
            })->export('xlsx');


        }

}
