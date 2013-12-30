@extends(Config::get('vedette::vedette_views.layout'))

{{-- Include Page CSS --}}
@section('css')
@stop

{{-- Include Page JS --}}
@section('js')
@stop

{{-- Browser Title --}}
@section('page_title')
	- {{ trans('lingos::auth.register') }}
@stop

{{-- Title --}}
@section('title')
	<i class="fa fa-pencil-square-o fa-lg"></i>
	{{ trans('lingos::auth.register') }}
@stop

{{-- Content --}}
@section('content')


<form method="POST" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>

        @if ( Session::get('error') )
            <div class="alert alert-error alert-danger">
                @if ( is_array(Session::get('error')) )
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if ( Session::get('notice') )
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>


{{ Form::open(array(
	'url' => route('vedette.register'),
	'method' => 'post',
	'id' => 'register-form'
	))
}}
<fieldset>


<fieldset>
<legend><i class="fa fa-user"></i>{{ trans('lingos::general.personal_information') }}</legend>
	<div class="input-group margin-bottom-lg">
		<span class="input-group-addon"><i class="fa fa-user"></i></span>
		<input class="form-control" type="text" name="username" id="username" placeholder="{{ trans('lingos::general.username') }}" value="{{ Input::old('username') }}"  tabindex="1">
	</div>
	<div class="input-group margin-bottom-lg">
		<span class="input-group-addon"><i class="fa fa-check-circle"></i></span>
		<input class="form-control" type="text" name="first_name" id="first_name" placeholder="{{ trans('lingos::general.first_name') }}" value="{{ Input::old('first_name') }}"  tabindex="1">
	</div>
	<div class="input-group margin-bottom-lg">
		<span class="input-group-addon"><i class="fa fa-check-circle-o"></i></span>
		<input class="form-control" type="text" name="last_name" id="last_name" placeholder="{{ trans('lingos::general.last_name') }}" value="{{ Input::old('last_name') }}"  tabindex="1">
	</div>
</fieldset>

<fieldset>
<legend><i class="fa fa-envelope-o"></i>{{ trans('lingos::general.email') }}</legend>
	<div class="input-group margin-bottom-lg">
		<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
		<input class="form-control" type="text" name="email" id="email" placeholder="{{ trans('lingos::general.email') }}" value="{{ Input::old('email') }}"  tabindex="1">
	</div>
</fieldset>

<fieldset>
<legend><i class="fa fa-key"></i>{{ trans('lingos::auth.password') }}</legend>
	<div class="input-group margin-bottom-md">
		<span class="input-group-addon"><i class="fa fa-unlock-o"></i></span>
		<input class="form-control"  type="password" name="password" id="password" placeholder="{{ trans('lingos::auth.password') }}" value="{{ Input::old('password') }}" tabindex="2">
	</div>
	<div class="input-group margin-bottom-md">
		<span class="input-group-addon"><i class="fa fa-unlock"></i></span>
		<input class="form-control"  type="password" name="confirm_password" id="confirm_password" placeholder="{{ trans('lingos::auth.confirm_password') }}" value="{{ Input::old('confirm_password') }}" tabindex="2">
	</div>
</fieldset>

<hr>

<div class="row btn-toolbar" role="toolbar">
	<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.register') }}" tabindex="4">
	<br>
	<a class="btn btn-warning" href="{{ route('vedette.home') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
	<input class="btn-inverse btn" type="reset" value="{{ trans('lingos::button.reset') }}">
	<a class="btn btn-info" href="{{ route('vedette.forgot-password') }}"><i class="fa fa-external-link"></i>{{ trans('lingos::button.forgot_password') }}</a>
</div>

{{ Form::close() }}

<div class="page-header">
	<h1>Signup</h1>
</div>
{{ Confide::makeSignupForm()->render() }}
@stop
