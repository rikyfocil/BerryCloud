<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
    @stack('css')
    <link rel="stylesheet" href="{{ asset('fontawsome/css/font-awesome.min.css') }}">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/style.css') }}" rel="stylesheet">

    
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BerryCloud')</title>

    <script type="text/javascript">
      var base_url = '{!! url("/") !!}';
    </script>

</head>
<body>

<nav class = "navbar navbar-default" role = "navigation">

   <div class = "navbar-header">
      <button type = "button" class = "navbar-toggle"
         data-toggle = "collapse" data-target = "#example-navbar-collapse">
         <span class = "sr-only">Toggle navigation</span>
         <span class = "icon-bar"></span>
         <span class = "icon-bar"></span>
         <span class = "icon-bar"></span>
      </button>


        @if(Auth::check())
            <a class="navbar-brand" href="{{ route('home') }}">
                <img alt="BerryCloud" src="{{ asset('/img/logo.png') }}">
            </a>
            <h3 class="navbar-text">BerryCloud</h3>
        @else
            <a class="navbar-brand" href="{{ route('/') }}">
                <img alt="BerryCloud" src="{{ asset('/img/logo.png') }}">
            </a>
            <h3 class="navbar-text">BerryCloud</h3>
            </div>
        @endif
   </div>

    @if(Auth::check())
        <div class = "collapse navbar-collapse" id = "example-navbar-collapse">
            <ul class = "nav navbar-nav navbar-right">

                <li><a href = "{{route('home')}}">Home</a></li>
                <li><a href = "{{route('shared')}}">Shared With Me</a></li>
                <li><a href = "{{route('trash')}}">Trash</a></li>
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
        </div>
    @else

    <div class = "collapse navbar-collapse" id = "example-navbar-collapse">
        <ul class = "nav navbar-nav navbar-right">
                <li><a href = "{{ route('login') }}">Login</a></li>
                <li><a href = "{{ route('register') }}">Sign Up</a></li>
        </ul>
    </div>
    @endif
</nav>

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
@yield('content')


    <!-- Latest compiled and minified Jquery -->
    <script src="http://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    @stack('scripts')

</body>

</html>
