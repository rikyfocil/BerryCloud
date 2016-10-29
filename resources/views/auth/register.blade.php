@extends('layouts.main')

@section('content')
<div class="container">
  <div class="text-center" style="padding:50px 0">
<div class="login-form-1">
  <h1> Sign Up </h1>
  <form id="register-form" role="form" method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}
    <div class="login-form-main-message"></div>
    <div class="main-login-form">

      <div class="login-group">

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="sr-only">Name</label>

              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">


                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif

        </div>



        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="sr-only">E-Mail Address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="E-mail">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif

        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="sr-only">Password</label>
                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
        </div>


        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm" class="sr-only">Password Confirm</label>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm password">

                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
        </div>

        <div class="form-group login-group-checkbox">
          <input type="checkbox" class="" id="reg_agree" name="reg_agree">
        </div>
      </div>
      <button type="submit" class="login-button"> <p>&#10217;</p> </button>
    </div>
    <div class="etc-login-form">
      <p><a href="{{ route('login') }}">Already have an account?</a></p>
    </div>
  </form>
</div>
</div>

</div>
@endsection
