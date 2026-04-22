@extends('admin.layouts.app')
@section('title', __('admin.users_title'))
@section('page-title', __('admin.users_title'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">{{ $user->name }}</div>
    <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>

<div class="admin-card" style="max-width:500px;">
    <div class="admin-card-header"><span class="admin-card-title"><i class="fa-solid fa-user" style="color:#C5A028;"></i> {{ __('admin.customer_data') }}</span></div>
    <div style="padding:1.25rem;">
        <div style="text-align:center; margin-bottom:1.5rem;">
            <div class="admin-avatar" style="width:64px; height:64px; font-size:1.5rem; margin:0 auto 0.75rem;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div style="font-weight:800; font-size:1.1rem;">{{ $user->name }}</div>
            <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}" style="margin-top:0.4rem;">
                {{ $user->is_active ? __('admin.status_active') : __('admin.status_suspended') }}
            </span>
        </div>
        @foreach([
            __('admin.email')             => $user->email,
            __('admin.registration_date') => $user->created_at->format('Y-m-d H:i'),
            __('admin.last_login')        => $user->last_login_at?->format('Y-m-d H:i') ?? __('admin.never_logged_in'),
        ] as $label => $value)
        <div style="padding:0.6rem 0; border-bottom:1px solid #F0F4F8; display:flex; justify-content:space-between;">
            <span style="color:#64748B; font-size:0.85rem;">{{ $label }}</span>
            <span style="font-weight:600; font-size:0.875rem;">{{ $value }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
