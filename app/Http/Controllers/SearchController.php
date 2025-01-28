<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class SearchController extends Controller
{
    /**
     * Display search results with filtering.
     */
    public function results(Request $request)
    {
        // Arama kriterlerini al
        $position = $request->input('position', null);
        $country = $request->input('country', null);
        $city = $request->input('city', null);
        $town = $request->input('town', null);
        $workingPreference = $request->input('working_preference', null);

        // Sorguyu oluştur
        $query = Job::query();

        if ($position) {
            $query->where('position', 'like', '%' . $position . '%');
        }

        if ($country) {
            $query->where('country', $country);
        }

        if ($city) {
            $query->where('city', $city);
        }

        if ($town) {
            $query->where('town', $town);
        }

        if ($workingPreference) {
            $query->where('working_preference', $workingPreference);
        }

        $jobs = $query->paginate(10); // Sayfalama

        return view('search.results', compact('jobs'));
    }
}
