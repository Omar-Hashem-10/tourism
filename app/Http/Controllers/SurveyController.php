<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:100'],
            'email'              => ['required', 'email', 'max:200'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'budget'             => ['required', 'in:low,medium,high,luxury'],
            'travel_type'        => ['required', 'in:family,couple,solo,friends'],
            'preferred_climate'  => ['required', 'in:beach,desert,mountain,city'],
            'duration_preference'=> ['required', 'in:weekend,week,twoweeks,month'],
            'message'            => ['nullable', 'string', 'max:1000'],
        ]);

        $response = SurveyResponse::create($validated);

        return redirect()->route('survey.results', $response->id);
    }

    public function results(SurveyResponse $response)
    {
        return view('survey.results', compact('response'));
    }
}
