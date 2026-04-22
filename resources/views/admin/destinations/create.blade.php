@extends('admin.layouts.app')
@section('title', __('admin.add_destination'))
@section('page-title', __('admin.add_destination'))

@section('content')
<div class="admin-page-header">
    <div class="admin-page-title">{{ __('admin.add_new_destination') }}</div>
    <a href="{{ route('admin.destinations.index') }}" class="admin-btn admin-btn-secondary">
        <i class="fa-solid fa-arrow-{{ app()->getLocale()==='ar' ? 'right' : 'left' }}"></i> {{ __('admin.back') }}
    </a>
</div>

@if($errors->any())
    <div class="admin-flash admin-flash-error"><i class="fa-solid fa-circle-xmark"></i> {{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">
    @csrf
    <div style="display:grid; grid-template-columns:1fr 280px; gap:1.25rem;">
        <div>
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.name') }}</span></div>
                <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div><label class="admin-label">{{ __('admin.title_ar') }}</label><input type="text" name="name[ar]" class="admin-input" value="{{ old('name.ar') }}" required></div>
                    <div><label class="admin-label">{{ __('admin.title_en') }}</label><input type="text" name="name[en]" class="admin-input" style="direction:ltr;" value="{{ old('name.en') }}" required></div>
                </div>
            </div>
            <div class="admin-card">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.description') }}</span></div>
                <div style="padding:1.25rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div><label class="admin-label">{{ __('admin.title_ar') }}</label><textarea name="description[ar]" class="admin-textarea" required>{{ old('description.ar') }}</textarea></div>
                    <div><label class="admin-label">{{ __('admin.title_en') }}</label><textarea name="description[en]" class="admin-textarea" style="direction:ltr;" required>{{ old('description.en') }}</textarea></div>
                </div>
            </div>
        </div>
        <div>
            <div class="admin-card" style="margin-bottom:1.25rem;">
                <div class="admin-card-header"><span class="admin-card-title">{{ __('admin.options') }}</span></div>
                <div style="padding:1.25rem;">
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.category') }}</label>
                        <select name="category" class="admin-select" required>
                            <option value="beach">🏖 {{ __('admin.cat_beach') }}</option>
                            <option value="culture">🏛 {{ __('admin.cat_culture') }}</option>
                            <option value="adventure">🏔 {{ __('admin.cat_adventure') }}</option>
                            <option value="heritage">🏺 {{ __('admin.cat_heritage') }}</option>
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">{{ __('admin.display_order') }}</label>
                        <input type="number" name="sort_order" class="admin-input" value="{{ old('sort_order', 0) }}" min="0">
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                        <span style="font-size:0.875rem; font-weight:700;">{{ __('admin.featured_destination') }}</span>
                        <label class="toggle-switch"><input type="checkbox" name="is_featured" value="1"><span class="toggle-slider"></span></label>
                    </div>
                    <div class="admin-form-group" style="margin:0;">
                        <label class="admin-label">{{ __('admin.image') }}</label>
                        <input type="file" name="image" class="admin-input" accept="image/*" style="padding:0.4rem;">
                    </div>
                </div>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary" style="width:100%; justify-content:center; padding:0.75rem;">
                <i class="fa-solid fa-floppy-disk"></i> {{ __('admin.save') }}
            </button>
        </div>
    </div>
</form>
@endsection
