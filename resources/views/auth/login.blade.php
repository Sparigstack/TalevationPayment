<title>Talevation Payments | Login</title>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="margin-top: 40px;">
        <div class="col-md-6 mllogin">
            <div class="panel panel-default">
                <div class="">
                    <img style="width: 30%;margin-top: 10px;" class="centerElement" src="{{url('/logo/TalevationLogo.png')}}">
                <div class="panel-heading centerElement">Payment System Login</div>
                </div>
                

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            

                            <div class="col-md-6 col-md-offset-3">
                                <label for="email" class="">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                           
                            <div class="col-md-6 col-md-offset-3">
                                 <label for="password" class="">Password</label>

                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-block btn btn-primary">
                                    Login
                                </button>

                                
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-4">
                                <a class="centerElement btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>

                                
                            </div>
                        </div>-->
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
