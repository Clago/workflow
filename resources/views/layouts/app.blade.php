<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="/vendor/toastr/build/toastr.css" rel="stylesheet"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script src="/vendor/toastr/build/toastr.min.js" type="text/javascript"></script>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        $(function(){
             $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
        });
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
</body>
@if(count($errors->all()))
    <?php
        $error_message='';
    ?>
    @foreach($errors->all() as $k=>$v)
    <?php 
        $error_message.=($k+1).".".$v."<br/>"; 
    ?>
    @endforeach
    <script>
        $(function(){
            toastr.error('{!!$error_message!!}');
        });
    </script>
@endif
<script type="text/javascript" src="/vendor/layer/src/layer.js"></script>
<script type="text/javascript">
    
    $(function(){
        var success='{{Session::get("success")}}';
        var message='{{Session::get("message")}}';
        if(success==1){
            toastr.success(message);
        }else if(success==-1){
            toastr.error(message);
        }

        //后台删除公共函数
        $('table,ol').on('click','.delete',function(e){
            var _this=$(this);
            var href=_this.data('href');
            
            layer.confirm('确定删除吗？',{
                btn:['确定','取消']
            },function(index){
                layer.close(index);
                $.ajax({
                    type:'DELETE',
                    url:href,
                    success:function(res){
                        var color='#659265';
                        if(res.error==0){
                            _this.parents('tr').remove();
                            _this.parents('li.dd-item').remove();
                            toastr.success(res.msg);
                        }else{
                            color='#C46A69';
                            toastr.error(res.msg);
                        }
                    }
                });
            },function(index){
                layer.close(index);
            });
            e.preventDefault();
        });
    });

</script>
</html>
