@extends('layouts.main')

<!-- Main Content -->
@section('content')
<div class="container">
  <div class="text-center" style="padding:50px 0">
  <h1> Reset password </h1>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
  	<div class="login-form-1">
  		<form class="text-left" role="form" method="POST" action="{{ url('/password/email') }}">
        {{ csrf_field() }}
  			<div class="etc-login-form">
  				<p>When you fill in your registered email address, you will be sent instructions on how to reset your password.</p>
  			</div>
  			<div class="login-form-main-message"></div>
  			<div class="main-login-form">
  				<div class="login-group">

            <div class="form-group">
  						  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="E-mail">

              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
          </div>

  					</div>
  				</div>
  				<button type="submit" class="login-button"><p>&#10217;</p></button>
  			</div>

  		</form>
  	</div>
  </div>
</div>
@endsection
