<H2>Hi <strong>This is ZioTes!</strong>,</H2>
{{--@php(dd($body))--}}

<H2>{{ $body[0]->date }}</H2>
<H1>총 사용 분  : {{ number_format($body[0]->billsec / 60) }}</H1>
<?php
$current_month = date('Y-m');
?>
<H2>{{ $current_month }}달 누적분수</H2>
<H1>총 사용 분  : {{ number_format($body[1]->billsec / 60) }}</H1>