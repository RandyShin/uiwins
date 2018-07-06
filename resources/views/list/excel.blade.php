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
			<td>{{ $cnt-- }}</td>
			<td>{{ $cdr->src }}</td>
			<td>{{ $cdr->dst }}</td>
			<td>{{ $cdr->disposition }}</td>
			<td>{{ $cdr->duration }}</td>
			<td>{{ substr($cdr->calldate,11,10) }}</td>
			<td>{{ substr($cdr->calldate,0,10) }}</td>
			<td>{{ $cdr->billsec }}</td>
		</tr>
	@endforeach
	</tbody>
</table>
</body>
</html>
