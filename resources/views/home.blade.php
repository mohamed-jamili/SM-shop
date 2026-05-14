@extends('layouts.app')

@section('title', 'SM-SHOP | Build Everywhere. Grow Effortlessly.')

@section('content')
    <x-loading-screen />
    <style>
        .home-layer {
            position: relative;
            z-index: 1;
        }
    </style>

    <div class="home-layer">
        <x-navbar />

        <main>
            <x-hero />


            <x-trusted />
            <x-features />
            <x-dashboard-preview />
            <x-cta />
        </main>

        <x-footer />
    </div>
@endsection