{{-- Šis skats attēlo "reset password" lapu vai saskarnes sadaļu. --}}

@extends('layouts.auth')

@section('title', __('auth.reset_password') . ' - FitLife')

@section('nav-action')
    <a href="{{ route('login') }}" class="auth-shell-nav-button auth-shell-nav-button--ghost">{{ __('auth.back_to_login') }}</a>
@endsection

@section('content')
    <div class="auth-shell-header">
        <div class="auth-shell-badge">Recovery</div>
        <div class="auth-shell-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>
        <h1 class="auth-shell-title"><span class="auth-shell-title-gradient">{{ __('auth.reset_password') }}</span></h1>
        <p class="auth-shell-subtitle">{{ __('auth.reset_password_subtitle') }}</p>
    </div>

    @if ($errors->any())
        <div class="auth-shell-alert auth-shell-alert--error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="auth-shell-form">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-shell-form-group">
            <label for="email" class="auth-shell-label">{{ __('auth.email') }}</label>
            <div class="auth-shell-input-wrap">
                <svg class="auth-shell-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $request->email) }}"
                    class="auth-shell-input @error('email') is-error @enderror"
                    placeholder="{{ __('auth.email') }}"
                    required
                    autofocus
                >
            </div>
        </div>

        <div class="auth-shell-form-group">
            <label for="password" class="auth-shell-label">{{ __('auth.new_password') }}</label>
            <div class="auth-shell-input-wrap">
                <svg class="auth-shell-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="auth-shell-input @error('password') is-error @enderror"
                    placeholder="{{ __('auth.new_password') }}"
                    required
                >
                <button type="button" class="auth-shell-password-toggle" onclick="togglePassword('password')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="auth-shell-form-group">
            <label for="password_confirmation" class="auth-shell-label">{{ __('auth.confirm_password') }}</label>
            <div class="auth-shell-input-wrap">
                <svg class="auth-shell-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="auth-shell-input"
                    placeholder="{{ __('auth.confirm_password') }}"
                    required
                >
                <button type="button" class="auth-shell-password-toggle" onclick="togglePassword('password_confirmation')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
        </div>

        <button type="submit" class="auth-shell-submit">{{ __('auth.set_new_password') }}</button>
    </form>

    <div class="auth-shell-footer">
        <span>{{ __('auth.remember_password') }}</span>
        <a href="{{ route('login') }}">{{ __('auth.back_to_login') }}</a>
    </div>
@endsection