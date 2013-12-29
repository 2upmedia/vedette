@extends(Config::get('vedette::vedette_views.layout'))

{{-- Include Page CSS --}}
@section('css')
@stop

{{-- Include Page JS --}}
@section('js')
@stop

{{-- Browser Title --}}
@section('page_title')
	- {{ trans('lingos::auth.sign_in') }}
@stop

{{-- Title --}}
@section('title')
	<i class="fa fa-sign-in fa-lg"></i>
	{{ trans('lingos::auth.sign_in') }}
@stop

{{-- Content --}}
@section('content')

@if ( Session::get('error') )
	<div class="alert alert-danger">{{ Session::get('error') }}</div>
@endif

@if ( Session::get('notice') )
	<div class="alert">{{ Session::get('notice') }}</div>
@endif


{{ Form::open(array(
	'url' => route('vedette.login'),
	'method' => 'post',
	'id' => 'login-form'
	))
}}
<fieldset>

	<div class="input-group margin-bottom-lg">
		<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
		<input class="form-control" type="text" name="email" id="email" placeholder="{{ trans('lingos::general.email') }}" value="{{ Input::old('email') }}"  tabindex="1">
	</div>

	<div class="input-group margin-bottom-md">
		<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
		<input class="form-control"  type="password" name="password" id="password" placeholder="{{ trans('lingos::auth.password') }}" value="{{ Input::old('email') }}" tabindex="2">
	</div>

	<div class="checkbox margin-bottom-lg">
		<label for="remember">{{ Lang::get('confide::confide.login.remember') }}
			<input type="hidden" name="remember" value="0">
			<input tabindex="3" type="checkbox" name="remember" id="remember" value="1">
		</label>
	</div>

	<div class="row btn-toolbar" role="toolbar">
		<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.sign_in') }}" tabindex="4">
		<br>
		<a class="btn btn-warning" href="{{ route('vedette.home') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
		<a class="btn btn-primary" href="{{ route('vedette.register') }}"><i class="fa fa-plus-circle"></i>{{ trans('lingos::button.register') }}</a>
		<a class="btn btn-info" href="{{ route('vedette.forgot-password') }}"><i class="fa fa-external-link"></i>{{ trans('lingos::button.forgot_password') }}</a>
	</div>

</fieldset>
{{ Form::close() }}

@stop
