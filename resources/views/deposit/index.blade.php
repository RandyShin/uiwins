<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>

<form method="post" action="{{url('deposit')}}">
    {{csrf_field()}}
    <div class="row">
        <div class="col-md-4"></div>
        <div class="form-group col-md-4">
            <label for="company">Company:</label>
            <div>
                <a href="reset.php">reset</a>
            </div>
            <input type="text" class="form-control" name="company" value="smi">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="form-group col-md-4">
            <label for="amount">Amount:</label>
            <input type="text" class="form-control" name="amount">
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-left:38px">Add Deposit</button>
        </div>
        <div class="col-md-4"></div>
        <div class="form-group col-md-4">
            <div>Deposit Total : {{ $deposit_total }}</div>
        </div>

    </div>
</form>

<div class="container">
    <br />
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div><br />
    @endif
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Company</th>
            <th>Amount</th>
            <th>Created At</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($deposits as $deposit)
            <tr>
                <td>{{$deposit->id}}</td>
                <td>{{$deposit->company}}</td>
                <td>{{$deposit->amount}}</td>
                <td>{{$deposit->created_at->format('Y-m-d')}}</td>
                <td><a href="{{action('DepositController@edit', $deposit['id'])}}" class="btn btn-warning">Edit</a></td>
                <td>
                    <form action="{{action('DepositController@destroy', $deposit['id'])}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>