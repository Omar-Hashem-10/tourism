@extends('admin.layouts.app')
@section('title', __('admin.subscribers_title'))
@section('page-title', __('admin.subscribers_page_title'))

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.subscribers_title') }}</div>
        <div class="admin-page-subtitle">{{ $subscribers->total() }}</div>
    </div>
    <a href="{{ route('admin.subscribers.export') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-file-csv"></i> {{ __('admin.export_csv') }}
    </a>
</div>

<form method="GET" class="admin-search-bar">
    <input type="text" name="search" class="admin-input" placeholder="🔍  {{ __('admin.search_email') }}" value="{{ request('search') }}" style="flex:1;">
    <button type="submit" class="admin-btn admin-btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
    @if(request('search'))
        <a href="{{ route('admin.subscribers.index') }}" class="admin-btn admin-btn-secondary">{{ __('admin.clear') }}</a>
    @endif
</form>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.email') }}</th>
                    <th>{{ __('admin.subscription_date') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $s)
                <tr>
                    <td style="color:#64748B; font-size:0.8rem;">{{ $s->id }}</td>
                    <td style="font-weight:600; direction:ltr; text-align:right;">{{ $s->email }}</td>
                    <td style="font-size:0.85rem; color:#64748B;">{{ $s->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if($s->is_active)
                            <span class="status-badge status-active">{{ __('admin.status_active') }}</span>
                        @else
                            <span class="status-badge status-inactive">{{ __('admin.status_not_active') }}</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.subscribers.destroy', $s) }}" onsubmit="return confirm('{{ __('admin.confirm_delete_subscriber') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:2rem; color:#64748B;">{{ __('admin.no_subscribers') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ $subscribers->total() }}</span>
        {{ $subscribers->links('admin.partials.pagination') }}
    </div>
</div>
@endsection
