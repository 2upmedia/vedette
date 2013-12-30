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
	<i class="fa fa-external-link fa-lg"></i>
	{{ trans('lingos::auth.forgot_password') }}
@stop

{{-- Content --}}
@section('content')

	@if ( Session::get('error') )
		<div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
	@endif

	@if ( Session::get('notice') )
		<div class="alert">{{{ Session::get('notice') }}}</div>
	@endif

	{{ Form::open(array(
		'url' => (Confide::checkAction('VedetteController@do_forgot_password')) ?: route('vedette.forgot-password'),
		'method' => 'POST',
		'id' => 'forgot-form'
		))
	}}
	<fieldset>

		<div class="input-group margin-bottom-lg">
			<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
			<input class="form-control" type="text" name="email" id="email" placeholder="{{ trans('lingos::general.email') }}" value="{{ Input::old('email') }}" tabindex="1">
		</div>

		<div class="row btn-toolbar" role="toolbar">
			<button class="btn btn-lg btn-success btn-block" type="submit" tabindex="2">{{ trans('lingos::button.send') }}</button>
			<br>
			<a class="btn btn-warning" href="{{{ route('vedette.home') }}}" tabindex="3"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
			<button class="btn-inverse btn" type="reset" tabindex="4">{{ trans('lingos::button.reset') }}</button>
		</div>

	</fieldset>
	{{ Form::close() }}

@stop
