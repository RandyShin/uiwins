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
        $cdrs = Cdr::orderBy('calldate', 'desc')
            ->paginate(15);

        $cnt = Cdr::count();



        return view('list.index')->withCdrs($cdrs)->withCnt($cnt);
    }



}
