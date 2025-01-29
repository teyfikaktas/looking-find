<?php
namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function results(Request $request)
    {
        $query = Job::query();

        // Pozisyon/Şirket araması
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

        $jobs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('search.results', compact('jobs'));
    }
}