<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

        // İlçe araması
        if ($request->filled('town')) {
            $query->where('town', 'like', '%' . $request->town . '%');
        }

        // Çalışma tercihi filtresi
        if ($request->filled('working_preference')) {
            $query->whereIn('working_preference', $request->working_preference);
        }

        // Tarih filtresi
        if ($request->filled('date_filter')) {
            if ($request->date_filter === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($request->date_filter === 'yesterday') {
                $query->whereDate('created_at', Carbon::yesterday());
            }
        }

        // Sıralama
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $jobs = $query->paginate(10)->withQueryString();

        return view('search.results', compact('jobs'));
    }
}