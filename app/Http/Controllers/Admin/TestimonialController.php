<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'review'    => 'required|string',
            'rating'    => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'avatar'    => 'nullable|image|max:1024',
        ]);

        $testimonial = Testimonial::create($validated);

        if ($request->hasFile('avatar')) {
            $testimonial->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم إضافة الرأي بنجاح.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'review'    => 'required|string',
            'rating'    => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'avatar'    => 'nullable|image|max:1024',
        ]);

        $testimonial->update($validated);

        if ($request->hasFile('avatar')) {
            $testimonial->clearMediaCollection('avatar');
            $testimonial->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم تحديث الرأي بنجاح.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم حذف الرأي.');
    }
}
