@extends('auth.shared')

@section('title', 'SM-SHOP | Login')
@section('auth-brand-copy', 'Sign in to manage your marketplace account.')

@section('auth-body')
    <div class="auth-header">
        <h2 class="auth-title">Welcome back</h2>
        <p class="auth-subtitle">Continue managing your global business.</p>
    </div>

    <form action="{{ route('login.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" placeholder="john@company.com" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem;">
                <label class="form-label" style="margin-bottom: 0;">Password</label>
                <a href="#" style="font-size: 0.85rem; color: #f97316; font-weight: 700;">Forgot?</a>
            </div>
            <div class="password-input-wrapper">
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                <button type="button" class="password-toggle">
                    <i data-lucide="eye"></i>
                </button>
            </div>
        </div>

        <div style="margin-bottom: 1.2rem;">
            <label style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem; cursor: pointer; color: #64748b;">
                <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} style="width: 20px; height: 20px; accent-color: #f97316; border-radius: 6px;">
                Keep me signed in
            </label>
        </div>

        <button type="submit" class="btn-auth">
            Sign In <i data-lucide="chevron-right"></i>
        </button>
    </form>

    <div class="auth-links">
        Don't have an account? <a href="{{ route('register') }}">Start Trial</a>
    </div>
@endsection



