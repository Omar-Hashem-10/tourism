<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $query = Trip::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereRaw("JSON_EXTRACT(title, '$.ar') LIKE ?", ["%$search%"])
                  ->orWhereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ["%$search%"]);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $trips = $query->orderBy('sort_order')->orderBy('id')->paginate(15)->withQueryString();

        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        return view('admin.trips.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateTrip($request);
        $validated['currency'] = '$';
        $validated['highlight_images'] = $this->storeHighlightImages($request);

        $trip = Trip::create($validated);

        if ($request->hasFile('image')) {
            $trip->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        if ($request->hasFile('flag')) {
            $trip->addMediaFromRequest('flag')
                ->toMediaCollection('flag');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file) {
                    $trip->addMedia($file)
                        ->toMediaCollection('gallery');
                }
            }
        }

        return redirect()->route('admin.trips.index')
            ->with('success', 'تم إضافة الرحلة بنجاح.');
    }

    public function edit(Trip $trip)
    {
        return view('admin.trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $this->validateTrip($request);
        $validated['currency'] = $trip->currency ?: '$';

        $existing = $trip->highlight_images ?? [];
        $validated['highlight_images'] = $this->storeHighlightImages($request, $existing);

        $trip->update($validated);

        if ($request->hasFile('image')) {
            $trip->clearMediaCollection('image');
            $trip->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        if ($request->hasFile('flag')) {
            $trip->clearMediaCollection('flag');
            $trip->addMediaFromRequest('flag')
                ->toMediaCollection('flag');
        }

        // حذف صور gallery محددة
        if ($request->has('gallery_delete')) {
            foreach ($request->input('gallery_delete', []) as $mediaId) {
                $media = Media::find($mediaId);
                if ($media) {
                    $media->delete();
                }
            }
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                if ($file) {
                    $trip->addMedia($file)
                        ->toMediaCollection('gallery');
                }
            }
        }

        return redirect()->route('admin.trips.index')
            ->with('success', 'تم تحديث الرحلة بنجاح.');
    }

    public function destroy(Trip $trip)
    {
        if ($trip->bookings()->exists()) {
            return back()->with('error', 'لا يمكن حذف رحلة لها حجوزات مرتبطة.');
        }

        $trip->delete();

        return redirect()->route('admin.trips.index')
            ->with('success', 'تم حذف الرحلة.');
    }

    public function toggleActive(Trip $trip)
    {
        $trip->update(['is_active' => !$trip->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $trip->is_active,
        ]);
    }

    private function validateTrip(Request $request): array
    {
        return $request->validate([
            'title.ar'            => 'required|string|max:200',
            'title.en'            => 'required|string|max:200',
            'country.ar'          => 'required|string|max:100',
            'country.en'          => 'required|string|max:100',
            'desc.ar'             => 'required|string',
            'desc.en'             => 'required|string',
            'highlights.ar'       => 'required|array|min:1',
            'highlights.ar.*'     => 'required|string',
            'highlights.en'       => 'required|array|min:1',
            'highlights.en.*'     => 'required|string',
            'highlight_images.*'  => 'nullable|image|max:2048',
            'gallery.*'           => 'nullable|image|max:4096',
            'flag'                => 'nullable|image|max:512',
            'price'               => 'required|numeric|min:0',
            'duration'            => 'required|integer|min:1',
            'category'            => 'required|in:beach,culture,adventure',
            'climate'             => 'required|in:beach,desert,mountain,city',
            'travel_type'         => 'required|array|min:1',
            'travel_type.*'       => 'in:family,couple,solo,friends',
            'budget_tier'         => 'required|in:low,medium,high,luxury',
            'is_egyptian'         => 'boolean',
            'spots_total'         => 'required|integer|min:1',
            'spots_left'          => 'required|integer|min:0',
            'departure_dates'     => 'nullable|array',
            'departure_dates.*'   => 'date',
            'image'               => 'nullable|image|max:2048',
            'is_active'           => 'boolean',
            'sort_order'          => 'nullable|integer|min:0',
        ]);
    }

    private function storeHighlightImages(Request $request, array $existing = []): array
    {
        $images = $existing;
        if ($request->hasFile('highlight_images')) {
            foreach ($request->file('highlight_images') as $idx => $file) {
                if ($file) {
                    $images[$idx] = $file->store('highlights', 'public');
                }
            }
        }
        return $images;
    }
}
