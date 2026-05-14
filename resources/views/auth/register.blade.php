@extends('auth.shared')

@section('title', 'SM-SHOP | Register')
@section('auth-brand-copy', 'Create your buyer or seller account with secure defaults.')

@section('auth-body')
    <div class="auth-header">
        <h2 class="auth-title">Create your account</h2>
        <div class="auth-title-line" style="width: 40px; height: 3px; background: #f97316; border-radius: 99px; margin-top: 0.6rem; margin-bottom: 0.8rem;"></div>
        <p class="auth-subtitle" style="font-size: 0.95rem; color: #64748b; line-height: 1.4; margin: 0;">Join as a buyer or seller and get started in seconds.</p>
    </div>

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div class="role-selector">
            <label class="role-card">
                <input type="radio" name="role" value="buyer" {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}>
                <i data-lucide="shopping-bag"></i>
                <strong>Buyer</strong>
            </label>
            <label class="role-card">
                <input type="radio" name="role" value="seller" {{ old('role') === 'seller' ? 'checked' : '' }}>
                <i data-lucide="store"></i>
                <strong>Seller</strong>
            </label>
        </div>

        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-input" placeholder="John Doe" value="{{ old('name') }}" required>
        </div>

        <div class="form-group" id="shop-name-group" style="display: {{ old('role') === 'seller' ? 'block' : 'none' }};">
            <label class="form-label">Shop Name</label>
            <input type="text" name="shop_name" id="shop_name" class="form-input" placeholder="Your brand name" value="{{ old('shop_name') }}">
        </div>

        <div class="form-group">
            <label class="form-label">Work Email</label>
            <input type="email" name="email" class="form-input" placeholder="john@company.com" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="password-input-wrapper">
                <input type="password" name="password" class="form-input" placeholder="At least 8 characters" required>
                <button type="button" class="password-toggle">
                    <i data-lucide="eye"></i>
                </button>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <div class="password-input-wrapper">
                <input type="password" name="password_confirmation" class="form-input" placeholder="Repeat your password" required>
                <button type="button" class="password-toggle">
                    <i data-lucide="eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-auth">
            Get Started <i data-lucide="chevron-right"></i>
        </button>
    </form>

    <div class="auth-links">
        Already have an account? <a href="{{ route('login') }}">Sign In</a>
    </div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const shopNameGroup = document.getElementById('shop-name-group');
            const shopNameInput = document.getElementById('shop_name');

            roleInputs.forEach(input => {
                input.addEventListener('change', () => {
                    if (input.value === 'seller') {
                        shopNameGroup.style.display = 'block';
                        shopNameInput.setAttribute('required', 'required');
                    } else {
                        shopNameGroup.style.display = 'none';
                        shopNameInput.removeAttribute('required');
                    }
                });
            });
        });
    </script>
@endpush
@endsection



