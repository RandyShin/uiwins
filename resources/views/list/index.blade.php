@extends('main')

@section('content')

    <div class="row">

        <div class="col-md-12">
            <span style="font-weight:900; font-size: 20px;">{{ Auth::user()->name }} Bill List Page</span>

            <div class="col-md-12">

                <form action="" method="GET" onsubmit="search()" id="frmsearch">

                    <table class="table tabled-bordered" style="margin-bottom: 0px;">
                        <tr>

                            <td style="padding-top: 12px;width: 416px;">
                                <input type="text" name="dateFrom" id="datepicker1" class="span3" value="{{ Request::get('from', Request::get('dateFrom', \Carbon\Carbon::now()->format('Y-m-d'))) }}" readonly style="display: inline-block;"> ~
                                <input type="text" name="dateTo" id="datepicker2" class="span3" value="{{ Request::get('to', Request::get('dateTo', \Carbon\Carbon::now()->format('Y-m-d'))) }}" readonly style="display: inline-block;">
                            </td>
                            <td style="width: 616px;">
                                <button type="submit" class="btn btn-search btn-block">
                                    <i class="fa fa-search"></i>Search
                                </button>
                            </td>
                            {{--@if (Auth::user()->name === 'admin')--}}
                            <td>
                                <a href="{{ url('excel') . '?' . http_build_query($params) }}" class="btn btn-warning">Excel</a>
                            </td>
                            {{--@endif--}}
                        </tr>
                    </table>

                </form>

            </div>




        <div class="col-md-12">

            <table id="mytable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>IDX</th>
                    <th>CID</th>
                    <th>DID</th>
                    <th>Disposition</th>
                    <th>Duration</th>
                    <th>CallTime</th>
                    <th>CallDate</th>
                    <th>Billsec</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cdrs as $cdr)
                    <tr>
                        <td>{{ str_replace('-','',(($cdrs->currentpage()-1) *15) - ($cnt--))  }}</td>
                        <td>{{ $cdr->src }}</td>
                        <td>{{ $cdr->did }}</td>
                        <td>{{ $cdr->disposition }}</td>
                        <td>{{ $cdr->duration }}</td>
                        <td>{{ substr($cdr->calldate,11,10) }}</td>
                        <td>{{ substr($cdr->calldate,0,10) }}</td>
                        <td>{{ $cdr->billsec }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <p>총 사용 초  : {{ number_format($total_billsec) }}</p>
            <p>총 사용 분  : {{ number_format($total_billsec / 60) }}</p>
        </div>

        <div class="text-center">
            {{ $cdrs->appends(Request::all())->links() }}
        </div>
    </div>

    <script>
        function popitup(url)
        {
            newwindow=window.open(url,'name','height=300,width=650,screenX=400,screenY=350');
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>

@endsection
