<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cdr;
use App\Deposit;
use DB;
use Excel;


class BalanceController extends Controller
{

    public $dateForm;
    public $dateTo;
    public $total;

    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $this->dateFrom   = \Request::get('dateFrom', Carbon::now()->format('Y-m-d'));
        $this->dateTo     = \Request::get('dateTo', Carbon::now()->format('Y-m-d'));
    }

    public function index(Request $request)
    {

        $params = $request->all();

        $cdrs = Cdr::where('dstchannel', 'like', 'SIP/SMI%')
            ->whereRaw('LENGTH(dst) != 4')
            ->where('calldate','>=', $this->dateFrom . ' 00:00:00')
            ->where('calldate','<=', $this->dateTo . ' 23:59:59')
            ->orderBy('calldate', 'desc')
            ->paginate(15);

        $prices = Cdr::where('dstchannel', 'like', 'SIP/SMI%')
            ->whereRaw('LENGTH(dst) != 4')
            ->get();


        $cnt = $cdrs->total();

        $this->getTotal();

        // get total price result
        $total = $this->total;

        // get total price result


        return view('list.index', compact('params', 'cdrs', 'cnt', 'total'));
    }

        public function excel()
        {


            $cdrs = Cdr::select('src as 발신번호','dst as 착신번호','disposition as 통화결과','duration as 통화시간','calldate as 통화날짜', 'billsec', 'billsec as 도수', 'billsec as 요금')
                ->where('dstchannel', 'like', 'SIP/SMI%')
                ->whereRaw('LENGTH(dst) != 4')
                ->where('calldate','>=', $this->dateFrom . ' 00:00:00')
                ->where('calldate','<=', $this->dateTo . ' 23:59:59')
                ->get();




//            $cdrs = Cdr::select('calldate', 'src', 'dst')->limit(50)->get();


            Excel::create('cdr', function($excel) use($cdrs) {
                $excel->sheet('Sheet', function($sheet) use($cdrs) {
                    $sheet->fromArray($cdrs);
                });
            })->export('xlsx');


        }

        public function process()
        {
            $this->getTotal();

            $deposits_total = Deposit::sum('amount');
            $total = $this->total;


//            return view('list.process')->withTotal($this->total);
            return view('list.process', compact('deposits_total', 'total'));
        }




        private function getTotal()
        {
            $prices = Cdr::where('dstchannel', 'like', 'SIP/SMI%')
                ->whereRaw('LENGTH(dst) != 4')
                ->get();

            $this->total = 0;

            foreach ($prices as $price)
            {
                if(substr($price->dst,'0','2') === '01');
                {
                    $this->total = $this->total + ceil($price->billsec/10)*6.8;
                }
                if(substr($price->dst, 0,2)==='86'){
                    $this->total = $this->total + ceil($price->billsec/60)*22;
                }
                if((substr($price->dst, 0,3)==='070') || (substr($price->dst,0,3) === '050' )) {
                    $this->total = $this->total + ceil($price->billsec/180)*45;
                }
                if((substr($price->dst, 0,2)!='01') && (substr($price->dst,0,2) != '86' ) && (substr($price->dst,0,3) != '070' ) && (substr($price->dst,0,3) != '050' )) {
                    $this->total = $this->total + ceil($price->billsec/180)*32;
                }
            }

        }

}
