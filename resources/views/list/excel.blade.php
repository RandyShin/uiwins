<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>
 
<body>

@php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=list.xls");
@endphp

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
			<td>{{ $cnt-- }}</td>
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
			
		</tr>
	@endforeach
	</tbody>
</table>
</body>
</html>
