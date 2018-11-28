<H2>Hi <strong>This is ZioTes!</strong>,</H2>
{{--@php(dd($body))--}}
<H2>{{ $body->date }}</H2>
<H1>총 사용 분  : {{ number_format($body->billsec / 60) }}</H1>

