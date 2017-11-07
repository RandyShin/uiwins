@extends('main')

@section('content')

    <div class="row">

        <div class="col-md-12">

            <h2>요금 관리 페이지</h2>
            <div class="col-md-12">

                <form action="" method="GET" onsubmit="search()" id="frmsearch">

                    <table class="table tabled-bordered">
                        <tr>

                            <td>
                                <input type="text" name="dateFrom" id="datepicker1" class="span3" value="{{ Request::get('from', \Carbon\Carbon::now()->format('Y-m-d')) }}" readonly style="display: inline-block;"> ~
                                <input type="text" name="dateTo" id="datepicker2" class="span3" value="{{ Request::get('to', \Carbon\Carbon::now()->format('Y-m-d')) }}" readonly style="display: inline-block;">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-search btn-block">
                                    <i class="fa fa-search"></i>Search
                                </button>
                            </td>

                        </tr>
                    </table>

                </form>

            </div>

        </div>


        <div class="col-md-12">

            <table id="mytable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>IDX</th>
                    <th>발신번호</th>
                    <th>착신번호</th>
                    <th>통화결과</th>
                    <th>통화시간</th>
                    <th>발신시간</th>
                    <th>통화날짜</th>
                    <th>billsec</th>
                    <th>착신종류</th>
                    <th>도수</th>
                    <th>요금</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cdrs as $cdr)
                    <tr>
                        <td>{{ str_replace('-','',(($cdrs->currentpage()-1) *15) - ($cnt--))  }}</td>
                        <td>{{ $cdr->src }}</td>
                        <td>{{ $cdr->dst }}</td>
                        <td>{{ $cdr->disposition }}</td>
                        <td>{{ $cdr->duration }}</td>
                        <td>{{ substr($cdr->calldate,11,10) }}</td>
                        <td>{{ substr($cdr->calldate,0,10) }}</td>
                        <td>{{ $cdr->billsec }}</td>
                        <td>{!! $cdr->getType() !!}</td>
                        <td>{{ $cdr->getUnit() }}</td>
                        <td>{{ $cdr->getPrice() }}</td>
                        {{--<td>{{ number_format($cdr->getPrice(), 1,'.',',') }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <p>남은 금액 : {{ 500000 - $total }}</p>
        </div>

        <div class="text-center">
            {{ $cdrs->appends(Request::all())->links() }}
        </div>
    </div>

    <a href="{{ url('excel') }}">Excel</a>

@endsection
