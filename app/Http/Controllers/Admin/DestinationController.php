<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::orderBy('sort_order')->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.ar'        => 'required|string|max:150',
            'name.en'        => 'required|string|max:150',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'category'       => 'required|in:beach,culture,adventure,heritage',
            'is_featured'    => 'boolean',
            'sort_order'     => 'nullable|integer|min:0',
            'image'          => 'nullable|image|max:2048',
        ]);

        $destination = Destination::create($validated);

        if ($request->hasFile('image')) {
            $destination->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.destinations.index')
            ->with('success', 'تم إضافة الوجهة بنجاح.');
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name.ar'        => 'required|string|max:150',
            'name.en'        => 'required|string|max:150',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'category'       => 'required|in:beach,culture,adventure,heritage',
            'is_featured'    => 'boolean',
            'sort_order'     => 'nullable|integer|min:0',
            'image'          => 'nullable|image|max:2048',
        ]);

        $destination->update($validated);

        if ($request->hasFile('image')) {
            $destination->clearMediaCollection('image');
            $destination->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->route('admin.destinations.index')
            ->with('success', 'تم تحديث الوجهة بنجاح.');
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('admin.destinations.index')
            ->with('success', 'تم حذف الوجهة.');
    }
}
