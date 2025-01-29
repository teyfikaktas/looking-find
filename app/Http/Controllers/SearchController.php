<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $query = Job::query();

        // Çalışma tercihlerini array olarak al
        $workingPreferences = $request->input('working_preference', []);
        if (!is_array($workingPreferences)) {
            $workingPreferences = [$workingPreferences];
        }

        // Position or company search
        if ($request->filled('position')) {
            $query->where(function($q) use ($request) {
                $q->where('position', 'like', '%' . $request->position . '%')
                  ->orWhere('company', 'like', '%' . $request->position . '%');
            });
        }

        // City search
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Country filter
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Town filter
        if ($request->filled('town')) {
            $query->where('town', $request->town);
        }

        // Working preference filter - Düzeltilmiş versiyonu
        if (!empty($workingPreferences)) {
            $query->whereIn('working_preference', $workingPreferences);
        }

        // Sort order
        $sortOrder = $request->get('sort', 'newest');
        if ($sortOrder === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination ve query string'i koru
        $jobs = $query->paginate(10)->withQueryString();

        return view('search.results', compact('jobs'));
    }

    public function getTowns($city)
    {
        $towns = Job::where('city', $city)
                   ->distinct()
                   ->pluck('town')
                   ->filter()
                   ->values();

        return response()->json($towns);
    }

    public function getCities($country)
    {
        $cities = Job::where('country', $country)
                    ->distinct()
                    ->pluck('city')
                    ->filter()
                    ->values();

        return response()->json($cities);
    }
}