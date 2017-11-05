@extends('main')

@section('content')

    <div class="row">


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
                        <td>
                            @php
                                if(substr($cdr->dst, 0,2)==='01'){
                                    echo "<font color='blue'>무선</font>";
                                }
                                if(substr($cdr->dst, 0,2)==='86'){
                                    echo "중국";
                                }
                                if((substr($cdr->dst, 0,3)==='070') || (substr($cdr->dst,0,3) === '050' )) {
                                    echo "특수";
                                }
                                if((substr($cdr->dst, 0,2)!='01') && (substr($cdr->dst,0,2) != '86' ) && (substr($cdr->dst,0,3) != '070' ) && (substr($cdr->dst,0,3) != '050' )) {
                                    echo "<font color='green'>유선</font>";
                                }


                            @endphp
                        </td>
                        <td>
                            @php
                                if(substr($cdr->dst, 0,2)==='01'){
                                    echo ceil($cdr->billsec/10);
                                }
                                if(substr($cdr->dst, 0,2)==='86'){
                                    echo ceil($cdr->billsec/60);
                                }
                                if((substr($cdr->dst, 0,3)==='070') || (substr($cdr->dst,0,3) === '050' )) {
                                    echo ceil($cdr->billsec/180);
                                }
                                if((substr($cdr->dst, 0,2)!='01') && (substr($cdr->dst,0,2) != '86' ) && (substr($cdr->dst,0,3) != '070' ) && (substr($cdr->dst,0,3) != '050' )) {
                                    echo ceil($cdr->billsec/180);
                                }

                            @endphp
                        </td>
                        <td>
                            @php
                                if(substr($cdr->dst, 0,2)==='01'){
                                    echo ceil($cdr->billsec/10)*6.8;
                                }
                                if(substr($cdr->dst, 0,2)==='86'){
                                    echo ceil($cdr->billsec/60)*22;
                                }
                                if((substr($cdr->dst, 0,3)==='070') || (substr($cdr->dst,0,3) === '050' )) {
                                    echo ceil($cdr->billsec/180)*45;
                                }
                                if((substr($cdr->dst, 0,2)!='01') && (substr($cdr->dst,0,2) != '86' ) && (substr($cdr->dst,0,3) != '070' ) && (substr($cdr->dst,0,3) != '050' )) {
                                    echo ceil($cdr->billsec/180)*32;
                                }

                            @endphp
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>




        <div class="text-center">
            {!! $cdrs->links() !!}
        </div>
    </div>




@endsection
