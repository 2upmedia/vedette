@extends(Config::get('vedette::views.email_layout'))

@section('content')
<p>{{ Lang::get('lingos::email.hello') }} {{ $user->first_name }},</p>

<p>{{ Lang::get('lingos::email.click_update_password') }}</p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>{{ Lang::get('lingos::email.regards') }},</p>

<p>{{ Config::get('vedette::site_config.site_team') }}</p>
@stop
