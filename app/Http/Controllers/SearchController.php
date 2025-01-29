<?php
// App\Http\Controllers\SearchController.php
namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $query = Job::query();

        // Pozisyon veya şirket araması
        if ($request->filled('position')) {
            $query->where(function($q) use ($request) {
                $q->where('position', 'like', '%' . $request->position . '%')
                  ->orWhere('company', 'like', '%' . $request->position . '%');
            });
        }

        // Şehir araması
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // Çalışma tercihi filtresi
        if ($request->filled('working_preference')) {
            $query->whereIn('working_preference', $request->working_preference);
        }

        // İlçe filtresi
        if ($request->filled('town')) {
            $query->where('town', 'like', '%' . $request->town . '%');
        }

        // Ülke filtresi
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        $jobs = $query->latest()->paginate(10)->withQueryString();

        return view('search.results', compact('jobs'));
    }
}