@extends('layouts.app')

@section('title', 'SM-SHOP | Seller Profile')

@push('styles')
    <style>
        :root {
            --sidebar-width: 280px;
            --surface-bg: #fdfcfb;
            --card-bg: #ffffff;
            --border-subtle: #f1f5f9;
            --text-main: #0f172a;
            --text-secondary: #64748b;
            --accent-brand: #f97316;
            --accent-soft: #fff7ed;
        }

        .dashboard-shell {
            min-height: 100vh;
            background: var(--surface-bg);
        }

        .dashboard-main {
            margin-left: var(--sidebar-width);
            padding: 2.5rem;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .profile-header {
            margin-bottom: 2.5rem;
        }

        .profile-header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 0.5rem;
            letter-spacing: -0.02em;
        }

        .profile-header p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        /* Profile Card */
        .workspace-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid var(--border-subtle);
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-section {
            padding: 2.5rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .card-section:last-child {
            border-bottom: none;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .section-title i {
            color: var(--accent-brand);
        }

        .section-title h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
        }

        /* Grid for Inputs */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .input-pro-group {
            margin-bottom: 1.5rem;
        }

        .input-pro-group:last-child {
            margin-bottom: 0;
        }

        .input-pro-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.6rem;
        }

        .input-pro {
            width: 100%;
            background: #fcfcfd;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .input-pro:focus {
            outline: none;
            border-color: var(--accent-brand);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.08);
        }

        .input-pro:disabled {
            background: #f1f5f9;
            cursor: not-allowed;
            color: #94a3b8;
        }

        /* Buttons */
        .btn-saas-primary {
            background: var(--accent-brand);
            color: #fff;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }

        .btn-saas-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(249, 115, 22, 0.3);
        }

        .btn-saas-secondary {
            background: #fff;
            color: var(--text-main);
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-saas-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        /* Avatar Section */
        .avatar-section {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .avatar-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #ea580c);
            display: grid;
            place-items: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            border: 4px solid #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            font-family: 'Outfit', sans-serif;
        }

        .avatar-actions h3 {
            margin: 0 0 0.5rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
        }

        .avatar-actions p {
            margin: 0 0 1rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-shell">
        <x-sidebar />

        <main class="dashboard-main">
            <div class="profile-container">
                <header class="profile-header">
                    <h1>Seller Settings</h1>
                    <p>Manage your personal details, shop information and account security.</p>
                </header>

                @if (session('success'))
                    <div style="background: #f0fdf4; color: #16a34a; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #bbf7d0; font-weight: 600;">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #fef2f2; color: #ef4444; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #fecaca; font-weight: 600;">
                        <ul style="margin: 0; padding-left: 1.25rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('seller.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="workspace-card">
                        {{-- Profile Overview --}}
                        <div class="card-section">
                            <div class="avatar-section">
                                @php
                                    $avatarPath = null;
                                    foreach(['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                                        if(file_exists(public_path('storage/avatars/' . $user->id . '.' . $ext))) {
                                            $avatarPath = asset('storage/avatars/' . $user->id . '.' . $ext);
                                            break;
                                        }
                                    }
                                @endphp
                                <div class="avatar-circle" id="profile-avatar-preview" style="{{ $avatarPath ? 'background-image: url('.$avatarPath.'); background-size: cover; background-position: center;' : '' }}">
                                    @if (!$avatarPath)
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="avatar-actions">
                                    <h3>Profile Photo</h3>
                                    <p>Upload a custom photo to personalize your seller profile.</p>
                                    <input type="file" name="profile_photo" id="profile_photo_input" style="display: none;" accept="image/*" onchange="previewAvatar(event)">
                                    <button type="button" class="btn-saas-secondary" onclick="document.getElementById('profile_photo_input').click()">
                                        <i data-lucide="camera" size="16"></i>
                                        <span>Change Avatar</span>
                                    </button>
                                </div>
                            </div>

                            <div class="section-title">
                                <i data-lucide="user" size="20"></i>
                                <h2>Personal Information</h2>
                            </div>

                            <div class="form-grid">
                                <div class="input-pro-group">
                                    <label>Full Name</label>
                                    <input type="text" name="name" class="input-pro" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="input-pro-group">
                                    <label>Email Address</label>
                                    <input type="email" name="email" class="input-pro" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Shop Information --}}
                        <div class="card-section">
                            <div class="section-title">
                                <i data-lucide="store" size="20"></i>
                                <h2>Shop Information</h2>
                            </div>

                            <div class="form-grid">
                                <div class="input-pro-group">
                                    <label>Shop Name</label>
                                    <input type="text" name="shop_name" class="input-pro" value="{{ old('shop_name', $user->shop_name) }}" placeholder="Your brand name">
                                </div>
                                <div class="input-pro-group">
                                    <label>Account Role</label>
                                    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                        <i data-lucide="shield-check" size="18" style="color: #16a34a;"></i>
                                        <span style="font-weight: 700; color: #1e293b; text-transform: capitalize;">{{ $user->role }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Contact & Address --}}
                        <div class="card-section">
                            <div class="section-title">
                                <i data-lucide="map-pin" size="20"></i>
                                <h2>Contact & Business Address</h2>
                            </div>

                            <div class="form-grid">
                                <div class="input-pro-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" class="input-pro" value="{{ old('phone', $user->phone) }}" placeholder="+1 (555) 000-0000">
                                </div>
                                <div class="input-pro-group">
                                    <label>Country</label>
                                    <input type="text" name="country" class="input-pro" value="{{ old('country', $user->country) }}" placeholder="e.g. United States">
                                </div>
                                <div class="input-pro-group">
                                    <label>City</label>
                                    <input type="text" name="city" class="input-pro" value="{{ old('city', $user->city) }}" placeholder="e.g. New York">
                                </div>
                                <div class="input-pro-group">
                                    <label>Postal Code</label>
                                    <input type="text" name="postal_code" class="input-pro" value="{{ old('postal_code', $user->postal_code) }}" placeholder="e.g. 10001">
                                </div>
                                <div class="input-pro-group">
                                    <label>Business Address</label>
                                    <input type="text" name="address" class="input-pro" value="{{ old('address', $user->address) }}" placeholder="123 Business Way">
                                </div>
                            </div>
                        </div>

                        {{-- Security --}}
                        <div class="card-section" style="background: #fafafa;">
                            <div class="section-title">
                                <i data-lucide="lock" size="20"></i>
                                <h2>Update Password</h2>
                            </div>
                            <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 2rem;">
                                Leave these fields blank if you do not want to change your password.
                            </p>
                            
                            <div class="form-grid">
                                <div class="input-pro-group">
                                    <label>New Password</label>
                                    <input type="password" name="password" class="input-pro" placeholder="••••••••">
                                </div>
                                <div class="input-pro-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="input-pro" placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                        {{-- Save Changes --}}
                        <div class="card-section" style="display: flex; justify-content: flex-end; background: #fff;">
                            <button type="submit" class="btn-saas-primary">
                                <i data-lucide="save" size="18"></i>
                                <span>Save Changes</span>
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Account Deletion --}}
                <div class="workspace-card" style="border-color: #fee2e2; margin-top: 4rem;">
                    <div class="card-section" style="background: #fffcfc;">
                        <div class="section-title" style="color: #dc2626;">
                            <i data-lucide="alert-triangle" size="20"></i>
                            <h2>Danger Zone</h2>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 2rem;">
                            <div>
                                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem;">Delete Account</h3>
                                <p style="color: var(--text-secondary); font-size: 0.9rem; margin: 0;">
                                    Permanently remove your account, products, and all associated data. This action is irreversible.
                                </p>
                            </div>
                            <form action="{{ route('seller.account.destroy') }}" method="POST" onsubmit="return confirm('WARNING: This will permanently delete your account and all your listings. Are you absolutely sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-saas-secondary" style="color: #dc2626; border-color: #fecaca; background: #fff;">
                                    <i data-lucide="trash-2" size="18"></i>
                                    <span>Delete Permanently</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div style="text-align: right; margin-bottom: 4rem; margin-top: 2rem;">
                    <p style="font-size: 0.8rem; color: #94a3b8;">Account created on {{ $user->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        function previewAvatar(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profile-avatar-preview');
                    preview.style.backgroundImage = 'url(' + e.target.result + ')';
                    preview.style.backgroundSize = 'cover';
                    preview.style.backgroundPosition = 'center';
                    preview.innerText = '';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endsection
