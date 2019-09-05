@extends('main')

@section('content')

    <div class="row">

        <div class="col-md-12">

            <span style="font-weight:900; font-size: 20px;">{{ Auth::user()->name }} Statistics Page</span>

            <div class="col-md-12">

                <form action="" method="GET" onsubmit="search()" id="frmsearch">

                    <table id="logtable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            @foreach($monthlyvalue as $item)
                            <th  style="text-align: center">{{ date("Y-m", strtotime($item->date)) }}</th>
                            @endforeach
                        </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($monthlyvalue as $item)
                                <td style="text-align: center">{{ (intval($item->billsec)) !== 0 ? number_format(ceil((intval($item->billsec))/60)) . " min" : "" }}</td>
                                @endforeach
                            </tr>


                        </tbody>
                    </table>

                    <table class="table tabled-bordered" style="margin-bottom: 0px;">
                        <tr>

                            <td style="padding-top: 12px;width: 250px;">
                                <input type="text" name="dateFrom" id="datepicker1" class="span3" value="{{ Request::get('from', Request::get('dateFrom', \Carbon\Carbon::now()->format('Y-m-d'))) }}" readonly style="display: inline-block;">
                            </td>
                            <td style="color: blue"><h4>Total : {{ number_format(ceil(($total)/60)) }} min</h4></td>
                            <td style="width: 616px;">
                                <button type="submit" class="btn btn-search btn-block">
                                    <i class="fa fa-search"></i>Search
                                </button>
                            </td>
                        </tr>
                    </table>

                </form>

                <div>
                    <table id="logtable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>DATE</th>
                            <th>MAX Concurrent</th>
                            <th>Total Min</th>
                        </tr>
                        </thead>

@php
   // dd($data);

   // echo '<pre>'; print_r($array); echo '</pre>';
@endphp

                        <tbody>

                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item['date'] }}</td>
                                <td>{{ $item['max'] }}</td>
                                <td>{{ (intval($item['billsec'])) !== 0 ? number_format(ceil((intval($item['billsec']))/60)) . " min" : "" }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


        </div>  <!-- /. End col-md-12  -->
    </div>  <!-- /. End Row  -->

@endsection
