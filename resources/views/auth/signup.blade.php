@extends('templates.default')


@section('title')
    sign up
@stop

@section('content')
    <div class="row">
        <h2>sign Up</h2>
        <div class="col-lg-6">
            <form role="form" action="{{ route('auth.signup')}}" method="POST" 
            class="form-vertical">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">your email address</label>
                    <input type="text" name="email" id="email" class="form-control"
                    value="{{
                        Request::old('email') ?: ''
                    }}">
                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="username" class="control-label"> username</label>
                    <input type="text" name="username" id="username" class="form-control"
                    value="{{
                        Request::old('username') ?: ''
                    }}">
                    @if ($errors->has('username'))
                        <span class="help-block">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">password</label>
                    <input type="text" name="password" id="password" class="form-control">
                    @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>

                    @else
                       <span class="help-block">minimalno 6 znakova</span> 
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Sign up</button>
                </div>  
                <input type="hidden" name="_token" value="{{ Session::token() }}">                      
            </form>
        </div>
    </div>
@stop