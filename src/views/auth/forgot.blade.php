@extends(Config::get('vedette::vedette_views.layout'))

{{-- Include Page CSS --}}
@section('css')
@stop

{{-- Include Page JS --}}
@section('js')
@stop

{{-- Browser Title --}}
@section('page_title')
	- {{ trans('lingos::auth.forgot_password') }}
@stop

{{-- Title --}}
@section('title')
	<i class="fa fa-external-link fa-lg fa-fw"></i>
	{{ trans('lingos::auth.forgot_password') }}
@stop

{{-- Content --}}
@section('content')

	@if ( Config::get('vedette::package_notifications') )
		@if (Session::has('error'))
			<div class="alert alert-danger alert-block">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				{{ Session::get('error') }}
			</div>
		@endif
		@if ( Session::get('status') )
			<div class="alert alert-info alert-block">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				{{ Session::get('status') }}
			</div>
		@endif
	@endif

	{{ Form::open(array(
		'route' => 'vedette.forgot',
		'method' => 'POST',
		'id' => 'forgot-form'
		))
	}}
	<fieldset>

		<div class="input-group margin-bottom-lg">
			<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
			<input class="form-control" type="text" name="email" id="email" placeholder="{{ trans('lingos::general.email') }}" value="{{ Input::old('email') }}" tabindex="1">
		</div>

		<div class="" role="toolbar">
			<button class="btn btn-lg btn-success btn-block" type="submit" tabindex="2">{{ trans('lingos::button.send') }}</button>
			<br>
			<a class="btn btn-warning" href="{{ route('vedette.home') }}" tabindex="3"><i class="fa fa-minus-circle fa-fw"></i>{{ trans('lingos::button.cancel') }}</a>
			<button class="btn-inverse btn" type="reset" tabindex="4">{{ trans('lingos::button.reset') }}</button>
		</div>

	</fieldset>
	{{ Form::close() }}

@stop
