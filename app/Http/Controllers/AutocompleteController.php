<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class AutocompleteController extends Controller
{
    private array $countries = [
        'Türkiye',
        'Amerika Birleşik Devletleri',
        'Almanya',
        'Fransa',
        'İngiltere',
        'İtalya',
        'İspanya',
        'Kanada',
        'Japonya',
        'Güney Kore',
        'Çin',
        'Rusya',
        'Avustralya',
        'Brezilya',
        'Hollanda',
        'Belçika',
        'Portekiz',
        'İsviçre',
        'Yunanistan',
        'İsveç',
        'Norveç',
        'Danimarka',
        'Finlandiya',
        'Avusturya',
        'Polonya',
        'Ukrayna',
        'Romanya',
        'Bulgaristan',
        'Macaristan',
        'İrlanda'
    ];

    public function countries(Request $request)
    {
        $term = $request->input('term', '');
        
        $filteredCountries = array_filter($this->countries, function($country) use ($term) {
            return stripos($country, $term) !== false;
        });

        $results = array_map(function($country) {
            return [
                'label' => $country,
                'value' => $country
            ];
        }, array_values($filteredCountries));

        return response()->json($results);
    }
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
