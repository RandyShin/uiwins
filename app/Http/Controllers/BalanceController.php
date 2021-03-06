<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Requests;
use App\Cdr;
use App\Deposit;
use DB;
use Excel;
use Auth;
use App\UiwinsCDR;


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



    function queryList() {

    if ( Auth::user()->name === 'admin') {
        $cdrs = Cdr::where('calldate','>=', $this->dateFrom . ' 00:00:00')
            ->where('calldate','<=', $this->dateTo . ' 23:59:59');
    }
        elseif (Auth::user()->name === 'uiwins') {  //show only 40 channels(benjamin request)
            $cdrs = Cdr::where('calldate','>=', $this->dateFrom . ' 00:00:00')
                        ->where('calldate','<=', $this->dateTo . ' 23:59:59')
                        ->where(function ($query) {
                            $query->orWhere('lastdata','LIKE','%632849116%');
                                //   ->orWhere('did','LIKE','0288491165%')
                                //   ->orWhere('did','LIKE','0288491166%');
                        });

            $totalCount = $cdrs->count();

            // $cdrs = $cdrs->limit($totalCount * .10);

        }
        else{
            $cdrs = Cdr::where('dstchannel', 'like', 'SIP/UnitedKingdom%')
                ->where('calldate','>=', $this->dateFrom . ' 00:00:00')
                ->where('calldate','<=', $this->dateTo . ' 23:59:59');
        }
        return $cdrs;
    }

    public function index(Request $request)
    {
        $params = $request->all();

        // $cdrs = $this->queryList()->orderBy('calldate', 'desc')->paginate(15);;
        // $cnt = $cdrs->total();

        $cdrs = $this->queryList()->orderBy('calldate', 'desc')->get();
        $cnt = $cdrs->count();

        $total_billsec = $this->getBillsec();

        $page = $request->get('page', 1);
        $perPage = 15;

        $cdrs = new LengthAwarePaginator(
            $cdrs->forPage($page, $perPage),
            $cdrs->count(),
            $perPage,
            $page,
            ['path' => url('/')]
        );

        return view('list.index', compact('params', 'cdrs', 'cnt', 'total_billsec'));
    }

    public function excel()
    {
        /*Excel::create('cdr', function($excel) use($cdrs) {
           $excel->sheet('Sheet', function($sheet) use($cdrs) {
               $sheet->fromArray($cdrs);
           });
         })->export('xlsx');*/

        $cdrs = $this->queryList();
        $cnt = $cdrs->count();
        $cdrs = $cdrs->orderBy('calldate', 'desc')->get();

        return view('list.excel', compact('cdrs', 'cnt'));


    }

    public function process()
    {
        $this->getTotal();

        $deposits_total = Deposit::sum('amount');
        $total = $this->total;


//            return view('list.process')->withTotal($this->total);
        return view('list.process', compact('deposits_total', 'total'));
    }


    public function getBillsec() {

        $billsec = $this->queryList()->get();

        $total_billsec = $billsec->sum('billsec');

        return $total_billsec;

    }

}
