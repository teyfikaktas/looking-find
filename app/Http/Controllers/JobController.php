<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;

class JobController extends Controller
{
    /**
     * Constructor: Authentication middleware.
     */
    public function __construct()
    {
        // create, store, edit, update, destroy metodları için auth middleware
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the jobs (Home Page).
     */
    public function index(Request $request)
    {
        // Mevcut şehir bilgisini al
        $currentCity = $request->input('current_city', null);

        // Arama kriterlerini al
        $position = $request->input('position', null);
        $city = $request->input('city', null);

        // Sorguyu oluştur
        $query = Job::query();

        if ($position) {
            $query->where('position', 'like', '%' . $position . '%');
        }

        if ($city) {
            $query->where('city', 'like', '%' . $city . '%');
        }

        if ($currentCity) {
            $query->where('city', $currentCity)->take(5);
        } else {
            $query->take(5);
        }

        $jobs = $query->get();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new job posting.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created job posting in storage.
     */
    public function store(Request $request)
    {
        // Doğrulama kuralları
        $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'town' => 'nullable|string|max:255',
            'working_preference' => 'required|in:remote,on-site,hybrid',
        ]);

        // İş ilanını oluştur
        Job::create([
            'user_id' => Auth::id(),
            'position' => $request->position,
            'company' => $request->company,
            'description' => $request->description,
            'country' => $request->country,
            'city' => $request->city,
            'town' => $request->town,
            'working_preference' => $request->working_preference,
        ]);

        return redirect()->route('jobs.index')->with('success', __('Job created successfully!'));
    }

    /**
     * Display the specified job posting.
     */
    public function show($id)
    {
        $job = Job::findOrFail($id);
        
        // İlgili ilanları getir (aynı şehirdeki diğer ilanlar)
        $relatedJobs = Job::where('id', '!=', $id)
            ->where('city', $job->city)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        // Rastgele başvuru sayısı ata (frontend'de gösterim için)
        $applicationCount = rand(1, 500);
        
        // Kullanıcı başvurmuş mu kontrol et
        $hasApplied = false;
        if (Auth::check()) {
            $hasApplied = Application::where('job_id', $id)
                                   ->where('user_id', Auth::id())
                                   ->exists();
        }

        return view('jobs.show', compact('job', 'relatedJobs', 'hasApplied', 'applicationCount'));
    }

    public function apply($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('warning', 'Başvuru yapabilmek için giriş yapmalısınız.');
        }

        $job = Job::findOrFail($id);
        
        // Daha önce başvurulmuş mu kontrol et
        $existingApplication = Application::where('job_id', $id)
                                        ->where('user_id', Auth::id())
                                        ->first();

        if ($existingApplication) {
            return back()->with('info', 'Bu ilana zaten başvurdunuz.');
        }

        // Yeni başvuru oluştur
        Application::create([
            'job_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Başvurunuz başarıyla alındı.');
    }

    /**
     * Show the form for editing the specified job posting.
     */
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('update', $job); // Policy kontrolü

        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified job posting in storage.
     */
    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('update', $job); // Policy kontrolü

        // Doğrulama kuralları
        $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'town' => 'nullable|string|max:255',
            'working_preference' => 'required|in:remote,on-site,hybrid',
        ]);

        // İş ilanını güncelle
        $job->update([
            'position' => $request->position,
            'company' => $request->company,
            'description' => $request->description,
            'country' => $request->country,
            'city' => $request->city,
            'town' => $request->town,
            'working_preference' => $request->working_preference,
        ]);

        return redirect()->route('jobs.show', $job->id)->with('success', __('Job updated successfully!'));
    }

    /**
     * Remove the specified job posting from storage.
     */
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('delete', $job); // Policy kontrolü

        $job->delete();

        return redirect()->route('jobs.index')->with('success', __('Job deleted successfully!'));
    }
}
