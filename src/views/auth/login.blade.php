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
		'url' => (Confide::checkAction('VedetteController@do_login')) ?: route('vedette.login'),
		'method' => 'POST',
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
		<input class="form-control"  type="password" name="password" id="password" placeholder="{{ trans('lingos::auth.password') }}" value="{{ Input::old('password') }}" tabindex="2">
	</div>

	<div class="checkbox margin-bottom-lg">
		<label for="remember">{{ Lang::get('confide::confide.login.remember') }}
			<input type="hidden" name="remember" value="0">
			<input type="checkbox" name="remember" id="remember" value="1" tabindex="3">
		</label>
	</div>

	<div class="row btn-toolbar" role="toolbar">
		<button class="btn btn-lg btn-success btn-block" type="submit" tabindex="4">{{ trans('lingos::button.sign_in') }}</button>
		<br>
		<a class="btn btn-warning" href="{{{ route('vedette.home') }}}" tabindex="5"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
		<a class="btn btn-primary" href="{{{ route('vedette.register') }}}" tabindex="6"><i class="fa fa-plus-circle"></i>{{ trans('lingos::button.register') }}</a>
		<a class="btn btn-info" href="{{{ (Confide::checkAction('VedetteController@forgot_password')) ?: route('vedette.forgot-password') }}}" tabindex="7"><i class="fa fa-external-link"></i>{{ trans('lingos::button.forgot_password') }}</a>
	</div>

	</fieldset>
	{{ Form::close() }}

@stop
