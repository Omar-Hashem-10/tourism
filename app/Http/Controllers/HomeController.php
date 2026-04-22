<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Testimonial;
use App\Models\Trip;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)->with('media')->get();
        $destinations = Destination::orderBy('sort_order')->with('media')->get();

        // Map trip id => image URL for JS injection; only trips that have an uploaded image
        $tripImages = Trip::with('media')->get()
            ->mapWithKeys(fn($t) => [$t->id => $t->getFirstMediaUrl('image') ?: null])
            ->filter()
            ->all();

        return view('home', compact('testimonials', 'destinations', 'tripImages'));
    }

    public function setLang(Request $request, string $locale)
    {
        if (!in_array($locale, ['ar', 'en'])) {
            abort(404);
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return redirect()->back();
    }
}
