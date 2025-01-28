<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class AutocompleteController extends Controller
{
    /**
     * Pozisyonlar için autocomplete.
     */
    public function positions(Request $request)
    {
        $term = $request->input('term');

        $positions = Job::where('position', 'like', '%' . $term . '%')
                        ->pluck('position')
                        ->unique()
                        ->take(10);

        return response()->json($positions);
    }

    /**
     * Şehirler için autocomplete.
     */
    public function cities(Request $request)
    {
        $term = $request->input('term');

        $cities = Job::where('city', 'like', '%' . $term . '%')
                     ->pluck('city')
                     ->unique()
                     ->take(10);

        return response()->json($cities);
    }
}
