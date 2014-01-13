@extends(Config::get('vedette::vedette_views.layout'))

{{-- Include Page CSS --}}
@section('css')
@stop

{{-- Include Page JS --}}
@section('js')
@stop

{{-- Browser Title --}}
@section('page_title')
	- {{ trans('lingos::auth.reset_password') }}
@stop

{{-- Title --}}
@section('title')
	<i class="fa fa-pencil-square-o fa-lg fa-fw"></i>
	{{ trans('lingos::auth.reset_password') }}
@stop

{{-- Content --}}
@section('content')

	@if ( Config::get('vedette::package_notifications') )
		@if (Session::has('error'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ Session::get('error') }}
			</div>
		@endif
		@if ( Session::get('status') )
			<div class="alert alert-info">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ Session::get('status') }}
			</div>
		@endif
	@endif

	{{ Form::open(array(
		'route' => array('vedette.reset', $token),
		'method' => 'POST',
		'id' => 'reset-form'
		))
	}}

	<input type="hidden" name="token" value="{{{ $token }}}">
	<fieldset>

	@if ( Config::get('vedette::use_username') )
	<div class="input-group margin-bottom-lg">
		<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
		<input class="form-control" type="text" name="username" id="username" placeholder="{{ trans('lingos::general.username') }}" value="{{ Input::old('username') }}" tabindex="1" autocorrect="off" autocapitalize="off">
	</div>
	@endif
	@if ( Config::get('vedette::use_email') )
	<div class="input-group margin-bottom-lg">
		<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
		<input class="form-control" type="text" name="email" id="email" placeholder="{{ trans('lingos::general.email') }}" value="{{ Input::old('email') }}"  tabindex="1" autocorrect="off" autocapitalize="off">
	</div>
	@endif

		<div class="input-group margin-bottom-md">
			<span class="input-group-addon"><i class="fa fa-unlock-o fa-fw"></i></span>
			<input class="form-control"  type="password" name="password" id="password" placeholder="{{ trans('lingos::auth.password') }}" value="{{ Input::old('password') }}" tabindex="3">
		</div>
		<div class="input-group margin-bottom-md">
			<span class="input-group-addon"><i class="fa fa-unlock fa-fw"></i></span>
			<input class="form-control"  type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ trans('lingos::auth.confirm_password') }}" value="{{ Input::old('password_confirmation') }}" tabindex="4">
		</div>

		<div class="row btn-toolbar" role="toolbar">
			<button class="btn btn-lg btn-success btn-block" type="submit" tabindex="4">{{ trans('lingos::button.reset') }}</button>
			<br>
			<a class="btn btn-warning" href="{{ route('vedette.home') }}" tabindex="5"><i class="fa fa-minus-circle fa-fw"></i>{{ trans('lingos::button.cancel') }}</a>
			<button class="btn-inverse btn" type="reset" tabindex="4">{{ trans('lingos::button.reset') }}</button>
		</div>

	</fieldset>
	{{ Form::close() }}


@stop
