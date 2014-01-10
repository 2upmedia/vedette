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
	<i class="fa fa-pencil-square-o fa-lg fa-fw"></i>
	{{ trans('lingos::auth.register') }}
@stop

{{-- Content --}}
@section('content')

	@if ( Config::get('vedette::package_notifications') )
		@if ( Session::get('error') )
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ Session::get('error') }}
			</div>
		@endif
{{-- Fallback Catch All Notice for Errors --}}
		@if (count($errors->all()) > 0)
			<div class="alert alert-danger alert-block">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				{{ Lang::get('lingos::auth.error.general_errors') }}
			</div>
		@endif
	@endif

	{{ Form::open(array(
		'url' => route('vedette.register'),
		'method' => 'post',
		'id' => 'register-form'
		))
	}}

	<fieldset>
	<legend><i class="fa fa-user fa-fw"></i>{{ trans('lingos::general.personal_information') }}</legend>
		<div class="input-group margin-bottom-lg">
			<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
			<input class="form-control" type="text" name="username" id="username" placeholder="{{ trans('lingos::general.username') }}" value="{{ Input::old('username') }}" tabindex="1">
		</div>
	</fieldset>

	<fieldset>
	<legend><i class="fa fa-envelope-o fa-fw"></i>{{ trans('lingos::general.email') }}</legend>
		<div class="input-group margin-bottom-lg">
			<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
			<input class="form-control" type="text" name="email" id="email" placeholder="{{ trans('lingos::general.email') }}" value="{{ Input::old('email') }}" tabindex="2">
		</div>
	</fieldset>

	<fieldset>
	<legend><i class="fa fa-key fa-fw"></i>{{ trans('lingos::auth.password') }}</legend>
		<div class="input-group margin-bottom-md">
			<span class="input-group-addon"><i class="fa fa-unlock-o fa-fw"></i></span>
			<input class="form-control"  type="password" name="password" id="password" placeholder="{{ trans('lingos::auth.password') }}" value="{{ Input::old('password') }}" tabindex="3">
		</div>
		<div class="input-group margin-bottom-md">
			<span class="input-group-addon"><i class="fa fa-unlock fa-fw"></i></span>
			<input class="form-control"  type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ trans('lingos::auth.confirm_password') }}" value="{{ Input::old('password_confirmation') }}" tabindex="4">
		</div>
	</fieldset>

	<fieldset>
	<legend><i class="fa fa-exclamation-triangle fa-fw"></i>{{ trans('lingos::auth.phrase') }}</legend>
		<div class="input-group margin-bottom-md">
			<span class="input-group-addon"><i class="fa fa-fire-extinguisher fa-fw"></i></span>
			<input class="form-control" type="text" name="phrase" id="phrase" placeholder="{{ trans('lingos::auth.phrase_detail') }}" value="{{ Input::old('phrase') }}" tabindex="5">
		</div>
	</fieldset>

	<hr>

	<div class="" role="toolbar">
		<button class="btn btn-lg btn-success btn-block" type="submit" tabindex="6">{{ trans('lingos::button.register') }}</button>
		<br>
		<a class="btn btn-warning" href="{{ route('vedette.home') }}" tabindex="7"><i class="fa fa-minus-circle fa-fw"></i>{{ trans('lingos::button.cancel') }}</a>
		<button class="btn-inverse btn" type="reset" tabindex="8">{{ trans('lingos::button.reset') }}</button>
		<a class="btn btn-info" href="{{ route('vedette.forgot') }}" tabindex="9"><i class="fa fa-external-link fa-fw"></i>{{ trans('lingos::button.forgot_password') }}</a>
	</div>

	{{ Form::close() }}

@stop
