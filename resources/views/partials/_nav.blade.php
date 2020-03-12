<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Balance Check System</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('/') ? "active" : "" }}"><a href="/">Home</a></li>
                @if(Auth::user() && Auth::user()->name !== 'uiwins')
                <li class="{{ Request::is('statistics') ? "active" : "" }}"><a href="/statistics">Statistics</a></li>
                <li class="{{ Request::is('china') ? "active" : "" }}"><a href="/china">China</a></li>
                @endif
                {{--<li class="{{ Request::is('contact') ? "active" : "" }}"><a href="/contact">Contact</a></li>--}}
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::user()->name !== 'uiwins')
                    <li class="">
                        <button type="button" class="btn btn-danger" style="line-height: 20px; margin-top: 8px;margin-right: 2px" id="MaxMonthConCurrent">Month Max <span class="badge"></span></button>
                    </li>
                    <li class="">
                        <button type="button" class="btn btn-warning" style="line-height: 20px; margin-top: 8px;margin-right: 2px" id="MaxConCurrent">Today Max <span class="badge"></span></button>
                    </li>
                    <li class="">
                        <button type="button" class="btn btn-primary" style="line-height: 20px; margin-top: 8px;" id="btnConCurrent">ConCurrent <span class="badge"></span></button>
                    </li>
                    <li class="dropdown">
                        <a href="/" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hello {{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>

                @else

                    <a href="{{ route('login') }}" class="btn btn-default">Login</a>

                @endif

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

@push('scripts')
<script src = "http://13.125.130.234:3000/socket.io/socket.io.js"></script>
<script type="text/javascript">
     $(function () {
         var socket = io(':3000');
         var con_current = $('#btnConCurrent span');
         var max_current = $('#MaxConCurrent span');
         var month_max_current = $('#MaxMonthConCurrent span');

         socket.on('connect', function(){
             socket.on('con current', function(data){
                 con_current.text(data.value)
             });

             socket.on('max current', function(data){
                 max_current.text(data.max);
                 month_max_current.text(data.month);
             });
         });
     });
</script>
@endpush