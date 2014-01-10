@extends(Config::get('vedette::vedette_views.email_layout'))

@section('content')
<p>{{ trans('lingos::email.hello') }} {{ $username }},</p>

<p>{{ trans('lingos::email.welcome_to') }} {{ Config::get('vedette::vedette_config.site_team') }}!
{{ trans('lingos::email.click_to_confirm') }}:</p>

<p>
<a href="{{ $confirmationUrl }}/{{ $confirmation_code }}">{{ $confirmationUrl }}</a>
</p>

{{ $confirmation_code }}
{{{ $confirmation_code }}}

<p>{{ trans('lingos::email.regards') }},</p>

<p>{{ Config::get('vedette::vedette_config.site_team') }}</p>
@stop
