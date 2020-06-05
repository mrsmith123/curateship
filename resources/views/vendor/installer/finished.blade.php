@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.final.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-flag-checkered fa-fw" aria-hidden="true"></i>
    {{ trans('installer_messages.final.title') }}
@endsection

@section('container')
	@if(session('message')['dbOutputLog'])
		<p><strong><h6>{{ trans('installer_messages.final.migration') }}</h6></strong></p>
		<pre><code>{{ session('message')['dbOutputLog'] }}</code></pre>
	@endif

	<p><strong><h6>{{ trans('installer_messages.final.console') }}</h6></strong></p>
	<pre><code>{{ $finalMessages }}</code></pre>

	<p><strong><h6>{{ trans('installer_messages.final.log') }}</h6></strong></p>
	<pre><code>{{ $finalStatusMessage }}</code></pre>

	<p><strong><h6>{{ trans('installer_messages.final.env') }}</h6></strong></p>
	<pre><code>{{ $finalEnvFile }}</code></pre>

    <div class="buttons">
        <a href="{{ url('/') }}" class="button button-secondary">
			<i class="fa fa-sign-out"></i>
			{{ trans('installer_messages.final.exit') }}
		</a>
        <a href="{{ route('LaravelInstaller::admin') }}" class="button">
			<i class="fa fa-user-plus"></i>
			Administrator Account
		</a>
    </div>

@endsection