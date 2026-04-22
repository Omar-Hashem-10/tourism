@extends('admin.layouts.app')
@section('title', __('admin.users_title'))
@section('page-title', __('admin.users_page_title'))

@section('content')
<div class="admin-page-header">
    <div>
        <div class="admin-page-title">{{ __('admin.users_title') }}</div>
        <div class="admin-page-subtitle">{{ $users->total() }}</div>
    </div>
</div>

<form method="GET" class="admin-search-bar">
    <input type="text" name="search" class="admin-input" placeholder="🔍  {{ __('admin.search_users') }}" value="{{ request('search') }}" style="flex:1;">
    <select name="status" class="admin-select" style="width:auto;">
        <option value="">{{ __('admin.all_users') }}</option>
        <option value="active"   {{ request('status')=='active'  ?'selected':'' }}>{{ __('admin.status_active') }}</option>
        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>{{ __('admin.status_suspended') }}</option>
    </select>
    <button type="submit" class="admin-btn admin-btn-primary"><i class="fa-solid fa-magnifying-glass"></i> {{ __('admin.search') }}</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-secondary">{{ __('admin.clear') }}</a>
    @endif
</form>

<div class="admin-card">
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.name') }}</th>
                    <th>{{ __('admin.email') }}</th>
                    <th>{{ __('admin.registration_date') }}</th>
                    <th>{{ __('admin.last_login') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td style="color:#64748B; font-size:0.8rem;">{{ $u->id }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.5rem;">
                            <div class="admin-avatar" style="width:30px; height:30px; font-size:0.75rem; flex-shrink:0;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <span style="font-weight:700;">{{ $u->name }}</span>
                        </div>
                    </td>
                    <td style="direction:ltr; text-align:right; font-size:0.85rem;">{{ $u->email }}</td>
                    <td style="font-size:0.8rem; color:#64748B;">{{ $u->created_at->format('Y-m-d') }}</td>
                    <td style="font-size:0.8rem; color:#64748B;">{{ $u->last_login_at?->format('Y-m-d') ?? __('admin.never_logged_in') }}</td>
                    <td>
                        <label class="toggle-switch" data-user-id="{{ $u->id }}" title="{{ $u->is_active ? __('admin.status_active') : __('admin.status_suspended') }}">
                            <input type="checkbox" class="user-toggle" {{ $u->is_active ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.3rem;">
                            <a href="{{ route('admin.users.show', $u) }}" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fa-solid fa-eye"></i></a>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('{{ __('admin.confirm_delete_user') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center; padding:2rem; color:#64748B;">{{ __('admin.no_users') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">
        <span>{{ $users->total() }}</span>
        {{ $users->links('admin.partials.pagination') }}
    </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.user-toggle').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const label  = this.closest('label');
        const userId = label.dataset.userId;

        fetch('/admin/users/' + userId + '/toggle', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => { if (!data.success) this.checked = !this.checked; })
        .catch(() => { this.checked = !this.checked; });
    });
});
</script>
@endpush
