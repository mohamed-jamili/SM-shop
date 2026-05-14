@extends('layouts.app')

@section('title', 'SM-SHOP | Marketplace')

@push('styles')
    <style>
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: #fdfcfb;
        }

        .main-content {
            flex: 1;
            margin-left: 300px;
            padding: 2rem;
            max-width: 1600px;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .search-wrapper {
            flex: 1;
            max-width: 600px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            border-radius: 14px;
            border: 1px solid #eee;
            background: #fff;
            font-size: 0.95rem;
            color: #111;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.08);
        }

        .search-icon {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #999;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-trigger,
        .cart-trigger {
            position: relative;
            width: 48px;
            height: 48px;
            display: grid;
            place-items: center;
            background: #fff;
            border-radius: 14px;
            border: 1px solid #eee;
            color: #111;
            transition: all 0.2s;
        }

        .notification-trigger:hover,
        .cart-trigger:hover {
            border-color: #f97316;
            color: #f97316;
        }

        .notification-count,
        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #f97316;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 10px;
            border: 2px solid #fff;
        }

        .cart-trigger {
            width: 48px;
            height: 48px;
        }

        .cart-trigger:hover {
            border-color: #f97316;
            color: #f97316;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #f97316;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 10px;
            border: 2px solid #fff;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid #f8f8f8;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
        }

        .product-image {
            aspect-ratio: 1 / 0.8;
            background: #f8f9fb;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            position: relative;
        }

        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.5rem;
        }

        /* Pro Dashboard Styles */
        .dashboard-top-section {
            margin-bottom: 3rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .dashboard-search-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .dash-search-wrapper {
            flex: 1;
            max-width: 650px;
            position: relative;
        }

        .dash-search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3.5rem;
            border: 1px solid #f1f1f1;
            border-radius: 16px;
            background: #fff;
            font-size: 1rem;
            color: #0f172a;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.01);
        }

        .dash-search-input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            transform: translateY(-1px);
        }

        .dash-search-icon {
            position: absolute;
            left: 1.3rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #64748b;
            transition: color 0.3s;
        }

        .dash-search-input:focus+.dash-search-icon {
            color: #f97316;
        }

        .dash-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dash-cart-btn {
            position: relative;
            width: 52px;
            height: 52px;
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 16px;
            display: grid;
            place-items: center;
            color: #0f172a;
            cursor: pointer;
            transition: all 0.3s;
        }

        .dash-cart-btn:hover {
            border-color: #f97316;
            color: #f97316;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.1);
        }

        .dash-cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f97316;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 800;
            width: 22px;
            height: 22px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 10px rgba(249, 115, 22, 0.3);
        }

        .dashboard-filter-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f1f1;
            padding-top: 1.5rem;
        }

        .dash-categories {
            display: flex;
            gap: 2.5rem;
        }

        .dash-cat-link {
            font-size: 0.9rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            position: relative;
            padding-bottom: 0.8rem;
            transition: all 0.3s;
        }

        .dash-cat-link:hover {
            color: #0f172a;
        }

        .dash-cat-link.active {
            color: #f97316;
        }

        .dash-cat-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: #f97316;
            border-radius: 4px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }

        .dash-cat-link.active::after {
            width: 100%;
        }

        .dash-filter-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Pro Dropdown Styles */
        .pro-dropdown {
            position: relative;
            min-width: 180px;
        }

        .pro-dropdown-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.75rem 1.25rem;
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
            cursor: pointer;
            transition: all 0.3s;
        }

        .pro-dropdown-trigger:hover {
            border-color: #f97316;
            background: #fff;
        }

        .pro-dropdown-trigger span {
            color: #64748b;
            font-weight: 600;
        }

        .pro-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 16px;
            padding: 0.5rem;
            min-width: 200px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            display: none;
            z-index: 1000;
            animation: slideDown 0.2s ease-out;
        }

        .pro-dropdown-menu.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pro-dropdown-item {
            padding: 0.7rem 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .pro-dropdown-item:hover {
            background: #fff7ed;
            color: #f97316;
        }

        .pro-dropdown-item.active {
            background: #f97316;
            color: #fff;
        }

        .dash-filter-btn {
            width: 44px;
            height: 44px;
            background: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 14px;
            display: grid;
            place-items: center;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s;
        }

        /* Profile Section Styles */
        .profile-container {
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
            animation: fadeIn 0.4s ease-out;
        }

        .profile-card {
            background: #fff;
            border-radius: 24px;
            padding: 2.5rem;
            border: 1px solid #f1f1f1;
            display: flex;
            gap: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .profile-avatar-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-right: 1px solid #f1f1f1;
            padding-right: 3rem;
        }

        .avatar-circle {
            width: 140px;
            height: 140px;
            background: #fff7ed;
            color: #f97316;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 3.5rem;
            font-weight: 900;
            position: relative;
            margin-bottom: 1.5rem;
        }

        .avatar-edit-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 36px;
            height: 36px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #64748b;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .avatar-edit-btn:hover {
            color: #f97316;
            transform: scale(1.05);
        }

        .avatar-delete-btn {
            position: absolute;
            bottom: 5px;
            left: 5px;
            width: 36px;
            height: 36px;
            background: #fff;
            border: 1px solid #fee2e2;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #ef4444;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.1);
            transition: all 0.2s;
        }

        .avatar-delete-btn:hover {
            background: #fef2f2;
            transform: scale(1.05);
        }

        .profile-info-text h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.4rem;
            text-align: center;
        }

        .profile-info-text p {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0;
            text-align: center;
        }

        .profile-form-section {
            flex: 2;
        }

        .profile-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .profile-field {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .profile-field label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .simple-input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            font-size: 0.95rem;
            color: #0f172a;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .simple-input:focus {
            outline: none;
            border-color: #f97316;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.05);
        }

        .simple-input:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .profile-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn-save-changes {
            background: #f97316;
            color: #fff;
            padding: 0.9rem 2.5rem;
            border-radius: 14px;
            font-weight: 800;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.2);
        }

        .btn-save-changes:hover {
            background: #ea580c;
            transform: translateY(-2px);
        }

        .btn-delete-account {
            background: #fff;
            color: #dc2626;
            padding: 0.9rem 2.5rem;
            border-radius: 14px;
            font-weight: 800;
            font-size: 0.95rem;
            border: 1px solid #fecaca;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-delete-account:hover {
            background: #fef2f2;
            border-color: #dc2626;
            transform: translateY(-2px);
        }

        /* Settings Page */
        .settings-container {
            max-width: 1050px;
        }

        .settings-header {
            margin-bottom: 2rem;
        }

        .settings-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.5rem;
            font-family: 'Outfit', sans-serif;
        }

        .settings-header p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .settings-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 0;
            overflow: hidden;
        }

        .settings-row {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            gap: 1.5rem;
            transition: background 0.2s;
            text-decoration: none;
            color: inherit;
        }

        a.settings-row:hover {
            background: #f8fafc;
        }

        .settings-row:last-child {
            border-bottom: none;
        }

        .settings-icon {
            width: 48px;
            height: 48px;
            background: #fff7ed;
            color: #f97316;
            border-radius: 50%;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .settings-icon i {
            width: 20px;
            height: 20px;
        }

        .settings-info {
            flex: 1;
        }

        .settings-info strong {
            display: block;
            color: #0f172a;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .settings-info p {
            color: #64748b;
            font-size: 0.85rem;
            margin: 0;
        }

        .settings-action {
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .settings-select {
            padding: 0.6rem 2.5rem 0.6rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #0f172a;
            background: #fff;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px;
            outline: none;
        }

        .theme-toggle-group {
            display: flex;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .theme-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
            color: #64748b;
            background: #fff;
            border: none;
            border-right: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
        }

        .theme-btn:last-child {
            border-right: none;
        }

        .theme-btn.active {
            color: #f97316;
        }

        .theme-btn i {
            width: 14px;
            height: 14px;
        }

        /* Checkbox Toggles */
        .notif-toggle {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            color: #475569;
            cursor: pointer;
        }

        .notif-toggle input {
            accent-color: #f97316;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Help Center */
        .help-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .help-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #fff7ed 0%, #fff 100%);
            border-radius: 20px;
            border: 1px solid #ffedd5;
        }

        .help-header h2 {
            font-size: 2.2rem;
            font-weight: 900;
            color: #0f172a;
            font-family: 'Outfit', sans-serif;
            margin-bottom: 1rem;
        }

        .help-header p {
            color: #64748b;
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0 auto 2rem;
        }

        .help-search-wrapper {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
        }

        .help-search-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 20px;
            height: 20px;
        }

        .help-search-input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            background: #fff;
            font-size: 1rem;
            color: #0f172a;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: all 0.3s;
        }

        .help-search-input:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .help-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .help-category-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s;
            text-decoration: none;
            display: block;
        }

        .help-category-card:hover {
            transform: translateY(-5px);
            border-color: #f97316;
            box-shadow: 0 15px 35px rgba(249, 115, 22, 0.08);
        }

        .help-cat-icon {
            width: 60px;
            height: 60px;
            background: #f8fafc;
            color: #f97316;
            border-radius: 16px;
            display: grid;
            place-items: center;
            margin: 0 auto 1.2rem;
            transition: all 0.3s;
        }

        .help-category-card:hover .help-cat-icon {
            background: #f97316;
            color: #fff;
        }

        .help-category-card h3 {
            color: #0f172a;
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .help-category-card p {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.5;
        }

        .faq-section {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .faq-section h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1.5rem;
            font-family: 'Outfit', sans-serif;
        }

        .faq-item {
            border-bottom: 1px solid #f1f5f9;
            padding: 1.2rem 0;
            cursor: pointer;
        }

        .faq-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            color: #0f172a;
            font-size: 1.05rem;
        }

        .faq-question i {
            color: #94a3b8;
            transition: transform 0.3s;
        }

        .faq-answer {
            margin-top: 1rem;
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            display: none;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }

        .contact-support {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #0f172a;
            border-radius: 20px;
            padding: 2rem 3rem;
            color: #fff;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .contact-support-info h3 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-family: 'Outfit', sans-serif;
        }

        .contact-support-info p {
            color: #94a3b8;
            font-size: 1rem;
            margin: 0;
        }

        .btn-contact {
            background: #f97316;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-contact:hover {
            background: #ea580c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        /* Contact Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .modal-overlay.show {
            display: flex;
            opacity: 1;
        }

        .contact-modal {
            background: #fff;
            border-radius: 24px;
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(20px);
            transition: transform 0.3s;
            position: relative;
        }

        .modal-overlay.show .contact-modal {
            transform: translateY(0);
        }

        .modal-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: #f1f5f9;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .contact-modal h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.5rem;
            font-family: 'Outfit', sans-serif;
        }

        .contact-modal p {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .contact-form .profile-field label {
            font-weight: 600;
            color: #0f172a;
        }

        .contact-form textarea.simple-input {
            min-height: 120px;
            resize: vertical;
            padding: 1rem;
        }

        .btn-submit-contact {
            background: #f97316;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-weight: 800;
            font-size: 1rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit-contact:hover {
            background: #ea580c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        /* Stats Cards */
        .account-summary-section h4,
        .quick-actions-section h4 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1.5rem;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 20px;
            border: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: #fff7ed;
            color: #f97316;
            display: grid;
            place-items: center;
        }

        .stat-info span {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: #94a3b8;
            margin-top: 0.2rem;
        }

        .stat-info strong {
            display: block;
            font-size: 1.15rem;
            font-weight: 900;
            color: #0f172a;
        }

        /* Quick Actions */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .action-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 20px;
            border: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .action-card:hover {
            border-color: #f97316;
            background: #fff7ed;
        }

        .action-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #f8fafc;
            color: #475569;
            display: grid;
            place-items: center;
            transition: all 0.3s;
        }

        .action-card:hover .action-icon {
            background: #fff;
            color: #f97316;
        }

        .action-content strong {
            display: block;
            font-size: 0.95rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.2rem;
        }

        .action-content p {
            font-size: 0.8rem;
            color: #64748b;
            margin: 0;
        }

        .action-arrow {
            margin-left: auto;
            color: #cbd5e1;
            transition: all 0.3s;
        }

        .action-card:hover .action-arrow {
            color: #f97316;
            transform: translateX(3px);
        }

        .product-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.3rem;
            line-height: 1.3;
        }

        .seller-name {
            font-size: 0.8rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .seller-name i {
            color: #cbd5e1;
        }

        .product-description {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .product-price-current {
            font-family: 'Outfit', sans-serif;
            font-size: 1.35rem;
            font-weight: 900;
            color: #f97316;
        }

        .product-price-old {
            color: #94a3b8;
            text-decoration: line-through;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .product-discount-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 11;
            background: #f97316;
            color: #fff;
            border-radius: 999px;
            padding: 0.35rem 0.65rem;
            font-size: 0.78rem;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.18);
        }

        .btn-add-cart {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #fff;
            border: 1px solid #eee;
            padding: 0.65rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #444;
            transition: all 0.2s;
        }

        .btn-add-cart:hover {
            background: #f97316;
            border-color: #f97316;
            color: #fff;
        }

        /* Favorite Button */
        .btn-favorite {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #eee;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: #ccc;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
        }

        .btn-favorite:hover {
            transform: scale(1.1);
            border-color: #fca5a5;
            color: #f87171;
        }

        .btn-favorite.active {
            background: #fff;
            border-color: #fecaca;
            color: #ef4444;
        }

        .btn-favorite.active i {
            fill: #ef4444;
        }

        /* Orders Tracking */
        .orders-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid #f1f1f1;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            display: grid;
            gap: 1.25rem;
        }

        .orders-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid #f1f1f1;
        }

        .orders-list {
            display: grid;
            gap: 1rem;
        }

        .buyer-order-card {
            border: 1px solid #f3f4f6;
            border-radius: 20px;
            padding: 1.4rem;
            background: #fff;
            display: grid;
            gap: 1.1rem;
        }

        .buyer-order-card:hover {
            border-color: #fed7aa;
            box-shadow: 0 12px 28px rgba(249, 115, 22, 0.08);
        }

        .buyer-order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .buyer-order-heading {
            display: grid;
            gap: 0.55rem;
        }

        .order-id {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            color: #111;
            font-size: 1.05rem;
        }

        .buyer-order-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            color: #888;
            font-size: 0.85rem;
        }

        .buyer-order-total {
            display: grid;
            justify-items: end;
            gap: 0.55rem;
        }

        .buyer-order-total strong {
            font-size: 1.1rem;
            color: #111;
        }

        .buyer-order-products {
            display: grid;
            gap: 0.75rem;
        }

        .buyer-order-product {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.85rem 1rem;
            border: 1px solid #f3f4f6;
            border-radius: 16px;
            background: #fcfcfd;
        }

        .buyer-order-product-thumb {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            object-fit: cover;
            border: 1px solid #f1f5f9;
            flex-shrink: 0;
        }

        .buyer-order-product-meta {
            display: grid;
            gap: 0.18rem;
            min-width: 0;
        }

        .buyer-order-product-meta strong {
            color: #0f172a;
            font-size: 0.92rem;
        }

        .buyer-order-product-meta span {
            color: #64748b;
            font-size: 0.8rem;
        }

        .buyer-order-product-total {
            margin-left: auto;
            color: #f97316;
            font-weight: 800;
            font-size: 0.9rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.8rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .status-badge.pending {
            background: #fffbeb;
            color: #d97706;
        }

        .status-badge.accepted {
            background: #f0fdf4;
            color: #16a34a;
        }

        .status-badge.preparing {
            background: #eff6ff;
            color: #2563eb;
        }

        .status-badge.shipping {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-badge.delivered {
            background: #ecfdf5;
            color: #059669;
        }

        .status-badge.rejected {
            background: #fef2f2;
            color: #dc2626;
        }

        .status-badge.partial {
            background: #fff7ed;
            color: #c2410c;
        }

        .order-tracking-card {
            border: 1px solid #f3f4f6;
            border-radius: 18px;
            background: #fcfcfd;
            padding: 1rem;
            display: grid;
            gap: 0.85rem;
        }

        .tracking-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .tracking-head strong {
            color: #0f172a;
            font-size: 0.92rem;
        }

        .tracking-head span {
            color: #64748b;
            font-size: 0.82rem;
        }

        .tracking-progress-bar {
            width: 100%;
            height: 8px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .tracking-progress-bar span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: #f97316;
        }

        .tracking-steps {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .tracking-step {
            display: grid;
            gap: 0.45rem;
            justify-items: center;
            text-align: center;
        }

        .tracking-step-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            background: #fff;
        }

        .tracking-step.completed .tracking-step-dot {
            border-color: #f97316;
            background: #f97316;
        }

        .tracking-step.current .tracking-step-dot {
            border-color: #f97316;
            background: #fff7ed;
            box-shadow: 0 0 0 6px rgba(249, 115, 22, 0.12);
        }

        .tracking-step-label {
            font-size: 0.76rem;
            font-weight: 700;
            color: #94a3b8;
            line-height: 1.35;
        }

        .tracking-step.completed .tracking-step-label,
        .tracking-step.current .tracking-step-label {
            color: #0f172a;
        }

        .order-note {
            padding: 0.9rem 1rem;
            border-radius: 16px;
            font-size: 0.84rem;
            line-height: 1.55;
        }

        .order-note.partial {
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }

        .order-note.rejected {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .orders-empty {
            text-align: center;
            padding: 4rem 1rem;
            color: #999;
        }

        .orders-empty p {
            margin: 0.8rem 0 1rem;
        }

        @media (max-width: 1280px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }

            .tracking-steps {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }

            .buyer-order-header,
            .tracking-head,
            .orders-summary {
                flex-direction: column;
                align-items: flex-start;
            }

            .buyer-order-total {
                justify-items: start;
            }

            .tracking-steps {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .buyer-order-product {
                align-items: flex-start;
            }

            .buyer-order-product-total {
                margin-left: 0;
            }

            .tracking-steps {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <x-sidebar />

        <main class="main-content">
            <!-- Redesigned Top Section -->
            @if(!in_array(request('tab'), ['settings', 'help']))
                <section class="dashboard-top-section">
                    @if(!in_array(request('tab'), ['orders', 'favorites', 'profile']))
                        <div class="dashboard-search-row">
                            <div class="dash-search-wrapper">
                                <i data-lucide="search" class="dash-search-icon"></i>
                                <form action="{{ route('buyer.home') }}" method="GET">
                                    <input type="text" name="search" class="dash-search-input"
                                        placeholder="Search for products, categories..." value="{{ request('search') }}">
                                </form>
                            </div>
                            <div class="dash-actions">
                                <a href="{{ route('notifications.index') }}" class="notification-trigger" title="View notifications">
                                    <i data-lucide="bell"></i>
                                    @if(auth()->user()->unreadNotifications()->count() > 0)
                                        <span class="notification-count notification-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('buyer.checkout') }}" class="cart-trigger">
                                    <i data-lucide="shopping-cart"></i>
                                    @if($cartCount > 0)
                                        <span class="cart-badge">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </div>
                        </div>

                        <div class="dashboard-filter-row">
                            <div class="dash-categories">
                                <a href="{{ route('buyer.home') }}"
                                    class="dash-cat-link {{ !request('category_id') ? 'active' : '' }}">General</a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('buyer.home', ['category_id' => $cat->id]) }}"
                                        class="dash-cat-link {{ request('category_id') == $cat->id ? 'active' : '' }}">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="dash-filter-group">
                                <div class="pro-dropdown" id="sortDropdown">
                                    <div class="pro-dropdown-trigger" onclick="toggleDropdown('sortDropdownMenu')">
                                        <span>Sort by:</span>
                                        <strong id="selectedSortLabel">
                                            @if(request('sort') === 'price_desc') Price: High to Low
                                            @elseif(request('sort') === 'price_asc') Price: Low to High
                                            @else Featured @endif
                                        </strong>
                                        <i data-lucide="chevron-down" style="width: 16px;"></i>
                                    </div>
                                    <div class="pro-dropdown-menu" id="sortDropdownMenu">
                                        <div class="pro-dropdown-item {{ !request('sort') || request('sort') === 'featured' ? 'active' : '' }}"
                                            onclick="applySort('featured')">
                                            <i data-lucide="sparkles" style="width: 16px;"></i> Featured
                                        </div>
                                        <div class="pro-dropdown-item {{ request('sort') === 'price_desc' ? 'active' : '' }}"
                                            onclick="applySort('price_desc')">
                                            <i data-lucide="trending-down" style="width: 16px;"></i> Price: High to Low
                                        </div>
                                        <div class="pro-dropdown-item {{ request('sort') === 'price_asc' ? 'active' : '' }}"
                                            onclick="applySort('price_asc')">
                                            <i data-lucide="trending-up" style="width: 16px;"></i> Price: Low to High
                                        </div>
                                    </div>
                                </div>
                                <form id="sortHiddenForm" action="{{ route('buyer.home') }}" method="GET">
                                    <input type="hidden" name="sort" id="sortHiddenInput" value="{{ request('sort') }}">
                                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request('category_id')) <input type="hidden" name="category_id"
                                    value="{{ request('category_id') }}"> @endif
                                </form>
                                <button class="dash-filter-btn">
                                    <i data-lucide="sliders-horizontal"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="dashboard-filter-row" style="border: none; padding: 0;">
                            <h2
                                style="font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 900; color: #0f172a; margin: 0; letter-spacing: -0.02em;">
                                @if(request('tab') === 'orders') My Orders
                                @elseif(request('tab') === 'profile') Profile
                                @elseif(request('tab') === 'favorites') My Favorites
                                @endif
                            </h2>
                            @if(request('tab') === 'profile')
                                <p style="color: #64748b; font-size: 0.95rem; margin: 0.3rem 0 0;">Manage your personal information.</p>
                            @endif
                        </div>
                    @endif
                </section>
            @endif

            @if(request('tab') === 'orders')
                <div class="orders-card">
                    <div class="orders-summary">
                        <span style="font-size: 0.85rem; color: #999;">Track each order from validation to delivery</span>
                        <span style="font-size: 0.85rem; color: #999;">Total: {{ $orders->count() }} orders</span>
                    </div>
                    <div class="orders-list">
                        @forelse($orders as $order)
                            @php($statusMeta = $order->status_meta)
                            <article class="buyer-order-card">
                                <div class="buyer-order-header">
                                    <div class="buyer-order-heading">
                                        <span class="order-id">Order #{{ $order->order_number }}</span>
                                        <div class="buyer-order-meta">
                                            <span>{{ ($order->ordered_at ?? $order->created_at)->format('M d, Y') }}</span>
                                            <span>{{ $order->items->count() }} products</span>
                                            <span>{{ str($order->payment_method)->replace('_', ' ')->title() }}</span>
                                        </div>
                                    </div>
                                    <div class="buyer-order-total">
                                        <span class="status-badge {{ $statusMeta['badge'] }}">
                                            <i data-lucide="{{ $statusMeta['icon'] }}" style="width: 12px; height: 12px;"></i>
                                            {{ $statusMeta['label'] }}
                                        </span>
                                        <strong>${{ number_format($order->total_amount, 2) }}</strong>
                                    </div>
                                </div>

                                <div class="buyer-order-products">
                                    @foreach($order->items as $item)
                                        <div class="buyer-order-product">
                                            @if($item->product?->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                                    alt="{{ $item->product?->name ?? 'Product image' }}"
                                                    class="buyer-order-product-thumb">
                                            @else
                                                <div class="buyer-order-product-thumb"
                                                    style="background: #f1f5f9; display: grid; place-items: center; color: #94a3b8;">
                                                    <i data-lucide="image" style="width: 18px; height: 18px;"></i>
                                                </div>
                                            @endif
                                            <div class="buyer-order-product-meta">
                                                <strong>{{ $item->product?->name ?? 'Deleted Product' }}</strong>
                                                <span>Qty: {{ $item->quantity }} x ${{ number_format($item->unit_price, 2) }}</span>
                                            </div>
                                            <span class="buyer-order-product-total">${{ number_format($item->subtotal, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="order-tracking-card">
                                    <div class="tracking-head">
                                        <div>
                                            <strong>Current status</strong>
                                            <span>{{ $statusMeta['description'] }}</span>
                                        </div>
                                        <span>{{ $order->status_label }}</span>
                                    </div>

                                    <div class="tracking-progress-bar">
                                        <span style="width: {{ $order->tracking_progress }}%;"></span>
                                    </div>

                                    <div class="tracking-steps">
                                        @foreach($order->tracking_steps as $step)
                                            <div class="tracking-step {{ $step['state'] }}">
                                                <span class="tracking-step-dot"></span>
                                                <span class="tracking-step-label">{{ $step['label'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if($order->status === \App\Models\Order::STATUS_PARTIALLY_ACCEPTED)
                                    <div class="order-note partial">
                                        This order contains a mix of accepted and non-accepted items. The timeline above follows the currently accepted products while the remaining items are still being resolved.
                                    </div>
                                @elseif($order->status === \App\Models\Order::STATUS_REJECTED)
                                    <div class="order-note rejected">
                                        The seller rejected this order. It will not continue to preparation or shipping.
                                    </div>
                                @endif
                            </article>
                        @empty
                            <div class="orders-empty">
                                <i data-lucide="shopping-bag"
                                    style="width: 48px; height: 48px; margin-bottom: 1rem; opacity: 0.2;"></i>
                                <p>You haven't placed any orders yet.</p>
                                <a href="{{ route('buyer.home') }}" style="color: #f97316; font-weight: 700;">Start Shopping</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            @elseif(request('tab') === 'profile')
                <div class="profile-container">
                    <!-- Profile Form Card -->
                    <div class="profile-card">
                        <div class="profile-avatar-section">
                            <div class="avatar-circle" id="avatarPreviewContainer">
                                <span id="avatarInitials">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                <label for="profile_image_input" class="avatar-edit-btn" style="cursor: pointer;"
                                    title="Upload photo">
                                    <i data-lucide="camera" style="width: 16px;"></i>
                                </label>
                                <button type="button" class="avatar-delete-btn" title="Remove photo"
                                    onclick="removeProfileImage()">
                                    <i data-lucide="trash-2" style="width: 16px;"></i>
                                </button>
                            </div>
                            <div class="profile-info-text">
                                <h3>{{ auth()->user()->name }}</h3>
                                <p>{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="profile-form-section">
                            <form action="{{ route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="profile_image_input" name="profile_image" accept="image/*"
                                    style="display: none;" onchange="previewProfileImage(event)">
                                <div class="profile-form-grid">
                                    <div class="profile-field">
                                        <label><i data-lucide="user" style="width: 16px; height: 16px;"></i> Full Name</label>
                                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="simple-input">
                                    </div>
                                    <div class="profile-field">
                                        <label><i data-lucide="mail" style="width: 16px; height: 16px;"></i> Email
                                            Address</label>
                                        <input type="email" name="email" value="{{ auth()->user()->email }}"
                                            class="simple-input" disabled>
                                    </div>
                                    <div class="profile-field">
                                        <label><i data-lucide="phone" style="width: 16px; height: 16px;"></i> Phone
                                            Number</label>
                                        <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                            class="simple-input" placeholder="+1 (555) 000-0000">
                                    </div>
                                    <div class="profile-field">
                                        <label><i data-lucide="calendar" style="width: 16px; height: 16px;"></i> Date of
                                            Birth</label>
                                        <input type="text" name="dob" class="simple-input" placeholder="DD / MM / YYYY">
                                    </div>
                                </div>
                                <div class="profile-actions">
                                    <button type="submit" class="btn-save-changes">Save Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="profile-card" style="display: block;">
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 1.5rem;">Address Information
                        </h4>
                        <form action="{{ route('buyer.profile.update') }}" method="POST">
                            @csrf
                            <div class="profile-form-grid">
                                <div class="profile-field">
                                    <label><i data-lucide="map-pin" style="width: 16px; height: 16px;"></i> Street
                                        Address</label>
                                    <input type="text" name="address" value="{{ auth()->user()->address ?? '' }}"
                                        class="simple-input" placeholder="123 Main St">
                                </div>
                                <div class="profile-field">
                                    <label><i data-lucide="building" style="width: 16px; height: 16px;"></i> City</label>
                                    <input type="text" name="city" value="{{ auth()->user()->city ?? '' }}" class="simple-input"
                                        placeholder="New York">
                                </div>
                                <div class="profile-field">
                                    <label><i data-lucide="map" style="width: 16px; height: 16px;"></i> Postal Code</label>
                                    <input type="text" name="postal_code" value="{{ auth()->user()->postal_code ?? '' }}"
                                        class="simple-input" placeholder="10001">
                                </div>
                                <div class="profile-field">
                                    <label><i data-lucide="globe" style="width: 16px; height: 16px;"></i> Country</label>
                                    <input type="text" name="country" value="{{ auth()->user()->country ?? '' }}"
                                        class="simple-input" placeholder="USA">
                                </div>
                            </div>
                            <div class="profile-actions">
                                <button type="submit" class="btn-save-changes">Save Address</button>
                            </div>
                        </form>
                    </div>

                    <!-- Security (Password) -->
                    <div class="profile-card" style="display: block;">
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0 0 1.5rem;">Security</h4>
                        <form action="{{ route('buyer.profile.update') }}" method="POST">
                            @csrf
                            <div class="profile-form-grid">
                                <div class="profile-field">
                                    <label><i data-lucide="lock" style="width: 16px; height: 16px;"></i> New Password</label>
                                    <input type="password" name="password" class="simple-input" placeholder="••••••••">
                                </div>
                                <div class="profile-field">
                                    <label><i data-lucide="shield-check" style="width: 16px; height: 16px;"></i> Confirm
                                        Password</label>
                                    <input type="password" name="password_confirmation" class="simple-input"
                                        placeholder="••••••••">
                                </div>
                            </div>
                            <div class="profile-actions">
                                <button type="submit" class="btn-save-changes">Update Password</button>
                            </div>
                        </form>
                    </div>

                    <!-- Danger Zone -->
                    <div class="profile-card" style="display: block; border-color: #fecaca; background: #fffbfa;">
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #dc2626; margin: 0 0 0.5rem;">Danger Zone</h4>
                        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Once you delete your account, there
                            is no going back. Please be certain.</p>

                        <form action="{{ route('buyer.account.destroy') }}" method="POST"
                            onsubmit="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <div class="profile-actions" style="justify-content: flex-start; margin-top: 0;">
                                <button type="submit" class="btn-delete-account">Delete Account</button>
                            </div>
                        </form>
                    </div>

                    <!-- Account Summary -->
                    <div class="account-summary-section">
                        <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem;">Account Summary
                        </h4>
                        <div class="stat-grid">
                            <div class="stat-card">
                                <div class="stat-icon"><i data-lucide="shopping-bag"></i></div>
                                <div class="stat-info">
                                    <strong>{{ $orders->count() }}</strong>
                                    <span>Total Orders</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon"><i data-lucide="wallet"></i></div>
                                <div class="stat-info">
                                    <strong>${{ number_format($orders->sum('total_amount'), 2) }}</strong>
                                    <span>Total Spent</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon"><i data-lucide="heart"></i></div>
                                <div class="stat-info">
                                    <strong id="profileFavoritesCount">0</strong>
                                    <span>Saved Items</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon"><i data-lucide="calendar-days"></i></div>
                                <div class="stat-info">
                                    <strong>{{ auth()->user()->created_at->format('M d, Y') }}</strong>
                                    <span>Member Since</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(request('tab') === 'settings')
                <div class="settings-container">
                    <div class="settings-header">
                        <h2>Settings</h2>
                        <p>Manage your account preferences and settings.</p>
                    </div>

                    <div class="settings-card">
                        <a href="{{ route('buyer.home', ['tab' => 'profile']) }}" class="settings-row">
                            <div class="settings-icon"><i data-lucide="user"></i></div>
                            <div class="settings-info">
                                <strong>Account Information</strong>
                                <p>Update your personal information and contact details.</p>
                            </div>
                            <div class="settings-action"><i data-lucide="chevron-right"></i></div>
                        </a>

                        <div class="settings-row" style="cursor: default;">
                            <div class="settings-icon"><i data-lucide="bell"></i></div>
                            <div class="settings-info">
                                <strong>Notifications</strong>
                                <p>Choose how you want to receive updates and alerts.</p>
                            </div>
                            <div class="settings-action">
                                <label class="notif-toggle">
                                    <input type="checkbox" checked> Email
                                </label>
                                <label class="notif-toggle">
                                    <input type="checkbox"> Push
                                </label>
                            </div>
                        </div>

                        <div class="settings-row" style="cursor: default;">
                            <div class="settings-icon"><i data-lucide="globe"></i></div>
                            <div class="settings-info">
                                <strong>Language & Region</strong>
                                <p>Select your language and region preferences.</p>
                            </div>
                            <div class="settings-action">
                                <select class="settings-select">
                                    <option value="en">English (US)</option>
                                    <option value="fr">Français</option>
                                    <option value="es">Español</option>
                                </select>
                            </div>
                        </div>

                        <div class="settings-row" style="cursor: default;">
                            <div class="settings-icon"><i data-lucide="moon"></i></div>
                            <div class="settings-info">
                                <strong>Appearance</strong>
                                <p>Choose your preferred theme for the application.</p>
                            </div>
                            <div class="settings-action">
                                <div class="theme-toggle-group">
                                    <button class="theme-btn active"><i data-lucide="sun"></i> Light</button>
                                    <button class="theme-btn"><i data-lucide="moon"></i> Dark</button>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="settings-row">
                            <div class="settings-icon"><i data-lucide="help-circle"></i></div>
                            <div class="settings-info">
                                <strong>Help Center</strong>
                                <p>Get help with your account and read our FAQ.</p>
                            </div>
                            <div class="settings-action"><i data-lucide="chevron-right"></i></div>
                        </a>

                        <a href="{{ route('buyer.home', ['tab' => 'profile']) }}" class="settings-row">
                            <div class="settings-icon"><i data-lucide="trash-2"></i></div>
                            <div class="settings-info">
                                <strong>Delete Account</strong>
                                <p>Permanently delete your account and all your data.</p>
                            </div>
                            <div class="settings-action"><i data-lucide="chevron-right"></i></div>
                        </a>
                    </div>
                </div>
            @elseif(request('tab') === 'help')
                <div class="help-container">
                    <div class="help-header">
                        <h2>Help Center</h2>
                        <p>How can we help you today? Search for articles or browse the categories below.</p>
                        <div class="help-search-wrapper">
                            <i data-lucide="search" class="help-search-icon"></i>
                            <input type="text" class="help-search-input"
                                placeholder="Search for answers, articles, and more...">
                        </div>
                    </div>

                    <div class="help-categories">
                        <a href="#" class="help-category-card">
                            <div class="help-cat-icon"><i data-lucide="book-open"></i></div>
                            <h3>Getting Started</h3>
                            <p>Guides to help you set up and use the platform effectively.</p>
                        </a>
                        <a href="#" class="help-category-card">
                            <div class="help-cat-icon"><i data-lucide="shopping-bag"></i></div>
                            <h3>Orders & Shipping</h3>
                            <p>Track your orders and understand our shipping policies.</p>
                        </a>
                        <a href="#" class="help-category-card">
                            <div class="help-cat-icon"><i data-lucide="refresh-cw"></i></div>
                            <h3>Returns & Refunds</h3>
                            <p>Information on how to return items and get refunded.</p>
                        </a>
                        <a href="#" class="help-category-card">
                            <div class="help-cat-icon"><i data-lucide="settings"></i></div>
                            <h3>Account Settings</h3>
                            <p>Manage your profile, password, and preferences.</p>
                        </a>
                    </div>

                    <div class="faq-section">
                        <h3>Frequently Asked Questions</h3>
                        <div class="faq-item" onclick="this.classList.toggle('active')">
                            <div class="faq-question">
                                How do I track my order?
                                <i data-lucide="chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                You can track your order by going to the 'Orders' tab in your dashboard. Click on the order you
                                want to track to see its current status and tracking number if available.
                            </div>
                        </div>
                        <div class="faq-item" onclick="this.classList.toggle('active')">
                            <div class="faq-question">
                                What is your return policy?
                                <i data-lucide="chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                We accept returns within 30 days of the delivery date. The item must be unused and in its
                                original packaging. Please check our Returns & Refunds category for more detailed instructions.
                            </div>
                        </div>
                        <div class="faq-item" onclick="this.classList.toggle('active')">
                            <div class="faq-question">
                                How do I change my shipping address?
                                <i data-lucide="chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                You can update your shipping address in the 'Profile' section under 'Address Information'. Make
                                sure to save your changes before leaving the page.
                            </div>
                        </div>
                        <div class="faq-item" onclick="this.classList.toggle('active')">
                            <div class="faq-question">
                                How do I contact customer support?
                                <i data-lucide="chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                If you need further assistance, you can click the 'Contact Support' button below to open a
                                ticket or email us directly at support@sm-shop.com. Our team usually responds within 24 hours.
                            </div>
                        </div>
                    </div>

                    <div class="contact-support">
                        <div class="contact-support-info">
                            <h3>Still need help?</h3>
                            <p>Our support team is always ready to help you with any issues.</p>
                        </div>
                        <a href="#" class="btn-contact"
                            onclick="event.preventDefault(); document.getElementById('contactModal').classList.add('show')">Contact
                            Support</a>
                    </div>
                </div>

                <!-- Contact Form Modal -->
                <div class="modal-overlay" id="contactModal">
                    <div class="contact-modal">
                        <button class="modal-close" onclick="document.getElementById('contactModal').classList.remove('show')">
                            <i data-lucide="x"></i>
                        </button>
                        <h3>Submit a Request</h3>
                        <p>Fill out the form below and we'll get back to you as soon as possible.</p>

                        <form action="{{ route('buyer.marketplace', ['tab' => 'help']) }}" method="GET" class="contact-form"
                            onsubmit="event.preventDefault(); alert('Request submitted successfully!'); document.getElementById('contactModal').classList.remove('show');">
                            @csrf
                            <div class="profile-field" style="margin-bottom: 1rem;">
                                <label>Subject</label>
                                <select name="subject" class="simple-input" style="appearance: auto;">
                                    <option value="order">Order Issue</option>
                                    <option value="return">Return / Refund</option>
                                    <option value="account">Account Problem</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="profile-field" style="margin-bottom: 1.5rem;">
                                <label>Description</label>
                                <textarea name="message" class="simple-input"
                                    placeholder="Please describe your issue in detail..." required></textarea>
                            </div>
                            <button type="submit" class="btn-submit-contact">Submit Request</button>
                        </form>
                    </div>
                </div>

            @else
                <!-- Product Grid (Home & Favorites) -->
                <div class="product-grid" id="productGrid">
                    @forelse($products as $product)
                        <article class="product-card" data-product-id="{{ $product->id }}">
                            <div class="product-image">
                                @if($product->has_discount)
                                    <span class="product-discount-badge">-{{ $product->discount_label }}%</span>
                                @endif
                                <button class="btn-favorite" onclick="toggleFavorite({{ $product->id }}, this)">
                                    <i data-lucide="heart" style="width: 20px; height: 20px;"></i>
                                </button>
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';">
                                    <div style="display: none; width: 100%; height: 100%; place-items: center; background: #f8fafc; color: #cbd5e1;">
                                        <i data-lucide="package" style="width: 64px; height: 64px; stroke-width: 1px;"></i>
                                    </div>
                                @else
                                    <div style="display: grid; width: 100%; height: 100%; place-items: center; background: #f8fafc; color: #cbd5e1;">
                                        <i data-lucide="package" style="width: 64px; height: 64px; stroke-width: 1px;"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">{{ $product->name }}</h3>
                                <p class="seller-name">
                                    <i data-lucide="store" style="width: 14px; height: 14px;"></i>
                                    by {{ $product->seller->shop_name ?? $product->seller->name ?? 'SM-Shop' }}
                                </p>
                                <p class="product-description">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                                @if($product->sizes || $product->colors)
                                    <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 1.25rem;">
                                        @if($product->sizes)
                                            @foreach(explode(',', $product->sizes) as $size)
                                                <span style="font-size: 0.65rem; background: #f1f5f9; color: #475569; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0; font-weight: 700;">{{ trim($size) }}</span>
                                            @endforeach
                                        @endif
                                        @if($product->colors)
                                            @foreach(explode(',', $product->colors) as $color)
                                                <span style="font-size: 0.65rem; background: #fff7ed; color: #c2410c; padding: 2px 6px; border-radius: 4px; border: 1px solid #fed7aa; font-weight: 700;">{{ trim($color) }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                <div class="product-footer">
                                    <div class="product-price" style="display: flex; flex-direction: column; gap: 2px;">
                                        @if($product->has_discount)
                                            <span class="product-price-current" style="color: #f97316; font-weight: 900; font-size: 1.2rem;">${{ number_format($product->final_price, 2) }}</span>
                                            <div style="display: flex; align-items: center; gap: 6px;">
                                                <span class="product-price-old" style="color: #94a3b8; text-decoration: line-through; font-size: 0.85rem;">${{ number_format($product->price, 2) }}</span>
                                                <span style="background: #f97316; color: #fff; font-size: 0.65rem; font-weight: 800; padding: 1px 6px; border-radius: 999px;">-{{ $product->discount_label }}%</span>
                                            </div>
                                        @else
                                            <span class="product-price-current" style="color: #0f172a; font-weight: 900; font-size: 1.2rem;">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <form action="{{ route('buyer.cart.store', $product) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                                        @csrf
                                        <div class="qty-selector" style="display: flex; align-items: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; height: 42px; overflow: hidden;">
                                            <button type="button" onclick="this.nextElementSibling.stepDown()" style="background: none; border: none; padding: 0 10px; color: #64748b; cursor: pointer; height: 100%; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">-</button>
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 40px; border: none; background: none; text-align: center; font-weight: 700; font-size: 0.9rem; color: #0f172a; padding: 0; margin: 0; -moz-appearance: textfield;">
                                            <button type="button" onclick="this.previousElementSibling.stepUp()" style="background: none; border: none; padding: 0 10px; color: #64748b; cursor: pointer; height: 100%; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">+</button>
                                        </div>
                                        <button type="submit" class="btn-add-cart" style="flex-grow: 1; height: 42px; padding: 0 1.25rem;">
                                            <i data-lucide="shopping-cart"></i>
                                            Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @empty
                        @if(request('search'))
                            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 0;">
                                <i data-lucide="search-x" style="width: 64px; height: 64px; color: #eee; margin-bottom: 1rem;"></i>
                                <h3 style="font-family: 'Outfit', sans-serif; color: #111;">No products found</h3>
                                <p style="color: #999;">Try adjusting your filters or search terms.</p>
                                <a href="{{ route('buyer.home') }}"
                                    style="display: inline-block; margin-top: 1.5rem; color: #f97316; font-weight: 700;">Reset
                                    filters</a>
                            </div>
                        @else
                            <div style="grid-column: 1 / -1; text-align: center; padding: 5rem 0;" id="emptyFavorites" class="hidden">
                                <i data-lucide="heart"
                                    style="width: 64px; height: 64px; color: #eee; margin-bottom: 1rem; opacity: 0.2;"></i>
                                <h3 style="font-family: 'Outfit', sans-serif; color: #111;">No favorites yet</h3>
                                <p style="color: #999;">Items you like will appear here.</p>
                                <a href="{{ route('buyer.home') }}"
                                    style="display: inline-block; margin-top: 1.5rem; color: #f97316; font-weight: 700;">Explore
                                    Marketplace</a>
                            </div>
                        @endif
                    @endforelse
                </div>

                @if($products->hasPages())
                    <div id="pagination" style="margin-top: 3rem; display: flex; justify-content: center;">
                        {{ $products->links() }}
                    </div>
                @endif
            @endif
        </main>
    </div>

    <script>
        // Custom Dropdown Logic
        function toggleDropdown(id) {
            const menu = document.getElementById(id);
            menu.classList.toggle('show');

            // Close other dropdowns if any
            document.querySelectorAll('.pro-dropdown-menu').forEach(m => {
                if (m.id !== id) m.classList.remove('show');
            });
        }

        function applySort(val) {
            document.getElementById('sortHiddenInput').value = val;
            document.getElementById('sortHiddenForm').submit();
        }

        // Close dropdowns on outside click
        window.addEventListener('click', (e) => {
            if (!e.target.closest('.pro-dropdown')) {
                document.querySelectorAll('.pro-dropdown-menu').forEach(m => m.classList.remove('show'));
            }
        });

        // Favorites Logic (LocalStorage)
        const currentTab = "{{ request('tab') }}";

        function getFavorites() {
            const favorites = localStorage.getItem('sm_favorites');
            return favorites ? JSON.parse(favorites) : [];
        }

        function refreshFavoritesBadge() {
            const count = getFavorites().length;
            const badge = document.getElementById('favoritesCountBadge');
            if (badge) {
                badge.innerText = count;
                badge.style.display = count > 0 ? 'block' : 'none';
            }

            const profileCount = document.getElementById('profileFavoritesCount');
            if (profileCount) {
                profileCount.innerText = count;
            }
        }

        function toggleFavorite(productId, button) {
            let favorites = getFavorites();
            const index = favorites.indexOf(productId);

            // Add animation class
            button.classList.add('heart-pop');
            setTimeout(() => button.classList.remove('heart-pop'), 450);

            if (index > -1) {
                favorites.splice(index, 1);
                button.classList.remove('active');
                if (currentTab === 'favorites') {
                    button.closest('.product-card').style.opacity = '0';
                    setTimeout(() => {
                        button.closest('.product-card').remove();
                        checkEmptyFavorites();
                    }, 300);
                }
            } else {
                favorites.push(productId);
                button.classList.add('active');
            }

            localStorage.setItem('sm_favorites', JSON.stringify(favorites));
            refreshFavoritesBadge();
        }

        function checkEmptyFavorites() {
            const grid = document.getElementById('productGrid');
            const emptyMsg = document.getElementById('emptyFavorites');
            if (grid && grid.querySelectorAll('.product-card').length === 0 && emptyMsg) {
                emptyMsg.classList.remove('hidden');
            }
        }

        function initFavorites() {
            const favorites = getFavorites();
            refreshFavoritesBadge();

            if (currentTab === 'favorites') {
                const pagination = document.getElementById('pagination');
                if (pagination) pagination.style.display = 'none';

                document.querySelectorAll('.product-card').forEach(card => {
                    const productId = parseInt(card.dataset.productId);
                    if (!favorites.includes(productId)) {
                        card.remove();
                    } else {
                        const btn = card.querySelector('.btn-favorite');
                        if (btn) btn.classList.add('active');
                    }
                });
                checkEmptyFavorites();
            } else {
                document.querySelectorAll('.product-card').forEach(card => {
                    const productId = parseInt(card.dataset.productId);
                    if (favorites.includes(productId)) {
                        const btn = card.querySelector('.btn-favorite');
                        if (btn) btn.classList.add('active');
                    }
                });
            }
        }

        function previewProfileImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const container = document.getElementById('avatarPreviewContainer');
                    const initials = document.getElementById('avatarInitials');
                    container.style.backgroundImage = 'url(' + e.target.result + ')';
                    container.style.backgroundSize = 'cover';
                    container.style.backgroundPosition = 'center';
                    if (initials) initials.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initFavorites();
        });
    </script>
    <style>
        .hidden {
            display: none !important;
        }

        .heart-pop {
            animation: heart-pop 0.45s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes heart-pop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.4);
            }

            100% {
                transform: scale(1.1);
            }
        }

        .product-card {
            transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease !important;
        }
    </style>
@endsection
