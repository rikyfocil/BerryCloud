<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
    <link href="{{ elixir('css/style.css') }}" rel="stylesheet">
    <meta charset="UTF-8">
    <title>@yield('title')</title>
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
		
    <a class="navbar-brand" href="{{ url('/w') }}">
        <img alt="BerryCloud" src="{{ url('/img/logo.png') }}">
    </a>
        <h3 class="navbar-text">BerryCloud</h3>
   </div>
   
    @if(Auth::check())
        <div class = "collapse navbar-collapse" id = "example-navbar-collapse">
            <ul class = "nav navbar-nav navbar-right">
                <li class = "dropdown">
                    <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">
                    User 
                    <b class = "caret"></b>
                    </a>
                    
                    <ul class = "dropdown-menu dropdown-menu-right">
                    <li><a href = "#">Home</a></li>
                    <li><a href = "#">Settings</a></li>
                    <li><a href = "#">Log Out</a></li>
                    </ul>
                    
                </li>
                    
            </ul>
        </div>
    @else
   
    <div class = "collapse navbar-collapse" id = "example-navbar-collapse">
        <ul class = "nav navbar-nav navbar-right">
                <li><a href = "{{ url('/login') }}">Login</a></li>
                <li><a href = "{{ url('/register') }}">Sign Up</a></li>
        </ul>
    </div>
    @endif
</nav>

@yield('content')
    
    
    
    
    
    
    
    <!-- Latest compiled and minified Jquery -->
    <script src="http://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
