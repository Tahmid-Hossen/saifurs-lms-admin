{{--
<div class="pull-right hidden-xs">
    <b>Version</b> {{ config('app.version') }}
</div>
--}}
<strong>
    Copyright &copy; {{ date('Y') }}
    <a href="{!! url(config('app.site_url')) !!}" style="color: #444">{!! config('app.name') !!}</a>.</strong>
All rights reserved.
@include('backend.layouts.pop-up-model')
