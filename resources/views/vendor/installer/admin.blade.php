@extends('vendor.installer.layouts.master')

@section('template_title')
    Administrator Account | CurateShip Installer
@endsection

@section('title')
    <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i>
    Create Administrator Account | CurateShip Installer
@endsection

@section('container')
<form action="{{ route('LaravelInstaller::admin.create') }}" method="post">
    @csrf
    <div class="form-group {{ $errors->has('name') ? ' has-error ' : '' }}">
        <label for="name">
        Name:
        </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
            placeholder="John Doe" />
        @if ($errors->has('name'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('name') }}
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('email') ? ' has-error ' : '' }}">
        <label for="email">
            Email:
        </label>
        <input type="text" name="email" id="email" value="{{ old('email') }}"
            placeholder="email@example.com" />

        @if ($errors->has('email'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password') ? ' has-error ' : '' }}">
        <label for="email">
            Password:
        </label>
        <input type="password" name="password" id="password" value="{{ old('password') }}"
            placeholder="************" />

        @if ($errors->has('password'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>
    <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">
        <label for="password_confirmation">
            Password Confirmation:
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            value="{{ old('password_confirmation') }}"
            placeholder="************" />

        @if ($errors->has('password_confirmation'))
            <span class="error-block">
                <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                {{ $errors->first('password_confirmation') }}
            </span>
        @endif
    </div>
    <button type="submit" href="{{ route('LaravelInstaller::admin') }}" class="button w-100"
        style="margin-bottom: 10px">
        <i class="fa fa-plus"></i>
        Create
    </button>
    <button type="button" class="button button-secondary w-100"
        onclick="redirectToHome()">
        
        <i class="fa fa-sign-out"></i>
        Skip
    </button>
</form>
@endsection

@section('scripts')
<script>
function redirectToHome() {
    window.location.href = "{{ url('/') }}";
};
</script>
@endsection
