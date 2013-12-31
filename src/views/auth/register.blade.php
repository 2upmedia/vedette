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

	{{ Form::open(array(
		'url' =>  (Confide::checkAction('VedetteController@store')) ?: route('vedette.register'),
		'method' => 'post',
		'id' => 'register-form'
		))
	}}

	<fieldset>
	<legend><i class="fa fa-user"></i>{{ trans('lingos::general.personal_information') }}</legend>
		<div class="input-group margin-bottom-lg">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			<input class="form-control" type="text" name="username" id="username" placeholder="{{ trans('lingos::general.username') }}" value="{{ Input::old('username') }}" tabindex="1">
		</div>
	</fieldset>

	<fieldset>
	<legend><i class="fa fa-envelope-o"></i>{{ trans('lingos::general.email') }}</legend>
		<div class="input-group margin-bottom-lg">
			<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
			<input class="form-control" type="text" name="email" id="email" placeholder="{{ trans('lingos::general.email') }}" value="{{ Input::old('email') }}" tabindex="2">
		</div>
	</fieldset>

	<fieldset>
	<legend><i class="fa fa-key"></i>{{ trans('lingos::auth.password') }}</legend>
		<div class="input-group margin-bottom-md">
			<span class="input-group-addon"><i class="fa fa-unlock-o"></i></span>
			<input class="form-control"  type="password" name="password" id="password" placeholder="{{ trans('lingos::auth.password') }}" value="{{ Input::old('password') }}" tabindex="3">
		</div>
		<div class="input-group margin-bottom-md">
			<span class="input-group-addon"><i class="fa fa-unlock"></i></span>
			<input class="form-control"  type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ trans('lingos::auth.confirm_password') }}" value="{{ Input::old('password_confirmation') }}" tabindex="4">
		</div>
	</fieldset>

	<hr>

	<fieldset>
		<div class="row btn-toolbar" role="toolbar">
			<button class="btn btn-lg btn-success btn-block" type="submit" tabindex="5">{{ trans('lingos::button.register') }}</button>
			<br>
			<a class="btn btn-warning" href="{{ route('vedette.home') }}" tabindex="6"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
			<button class="btn-inverse btn" type="reset" tabindex="7">{{ trans('lingos::button.reset') }}</button>
			<a class="btn btn-info" href="{{ route('vedette.forgot-password') }}" tabindex="8"><i class="fa fa-external-link"></i>{{ trans('lingos::button.forgot_password') }}</a>
		</div>
	</fieldset>

	{{ Form::close() }}

@stop
