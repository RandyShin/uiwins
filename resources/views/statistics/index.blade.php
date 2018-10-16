@extends('main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <span style="font-weight:900; font-size: 20px;">{{ Auth::user()->name }} Statistics Page</span>

            <div class="col-md-12">

                <form action="" method="GET" onsubmit="search()" id="frmsearch">

                    <table class="table tabled-bordered" style="margin-bottom: 0px;">
                        <tr>

                            <td style="padding-top: 12px;width: 250px;">
                                <input type="text" name="dateFrom" id="datepicker1" class="span3" value="{{ Request::get('from', Request::get('dateFrom', \Carbon\Carbon::now()->format('Y-m-d'))) }}" readonly style="display: inline-block;">
                            </td>
                            <td style="color: blue"><h4>Total : {{ number_format(ceil(($total)/60)) }}min</h4></td>
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

{{--@php--}}

    {{--dd($list);--}}

   {{--// echo '<pre>'; print_r($array); echo '</pre>';--}}

{{--exit;--}}
{{--@endphp--}}



                        <tbody>

                        @foreach($list as $key => $item)
                            <tr>
                                <td>{{ $key }}</td>
                                @if(isset($item))
                                    <td>{{ $item->max_value }}</td>
                                    <td>{{ number_format(ceil(($item->total_min)/60)) }}min</td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>


                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


        </div>  <!-- /. End col-md-12  -->
    </div>  <!-- /. End Row  -->

@endsection
