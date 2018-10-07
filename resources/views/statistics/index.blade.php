@extends('main')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <span style="font-weight:900; font-size: 20px;">{{ Auth::user()->name }} Statistics Page</span>

            <div class="col-md-12">

                <form action="" method="GET" onsubmit="search()" id="frmsearch">

                    <table class="table tabled-bordered" style="margin-bottom: 0px;">
                        <tr>

                            <td style="padding-top: 12px;width: 416px;">
                                <input type="text" name="dateFrom" id="datepicker1" class="span3" value="{{ Request::get('from', Request::get('dateFrom', \Carbon\Carbon::now()->format('Y-m-d'))) }}" readonly style="display: inline-block;">
                            </td>
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
    {{--print_r($data);--}}
   {{--// echo '<pre>'; print_r($array); echo '</pre>';--}}


{{--exit;--}}
{{--@endphp--}}
                        <tbody>

                        @foreach($data as $item)
                            @if(isset($item->id))
                            <tr>
                                <td>{{ substr($item->created_at, 0, 10) }}</td>
                                <td>{{ $item->value }}</td>
                                <td>{{ $item->value }}</td>
                            </tr>
                            @endif
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>


        </div>  <!-- /. End col-md-12  -->
    </div>  <!-- /. End Row  -->

@endsection
