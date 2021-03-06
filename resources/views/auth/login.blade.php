@extends('layouts.main')

@section('content')
<div class="container">
  <div class="text-center" style="padding:50px 0">

  <div class = "login-form-1">
    <h1> Login </h1>

    <form id="login-form" class="text-left" role="form" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
			<div class="login-form-main-message"></div>
			<div class="main-login-form">
				<div class="login-group">

          <div class="form-group">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
  						<label for="email" class="sr-only">E-Mail Address</label>
  						<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="E-mail">
              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
            </div>

					</div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="sr-only">Password</label>
                  <input id="password" type="password" class="form-control" name="password" required placeholder="password">
                  @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
          </div>





					<div class="form-group login-group-checkbox">
						<input type="checkbox" name="remember">
						<label for="remember">Remember Me</label>
					</div>
				</div>
				<button type="submit" class="login-button"><p>&#10217;</p></button>
			</div>
			<div class="etc-login-form">
				<p>Forgot your password? <a href="{{ route('reset') }}">click here</a></p>
			</div>
		</form>
    </div>

</div>


  </div>
</div>
@endsection
