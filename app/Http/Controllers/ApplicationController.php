<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Constructor: Authentication middleware.
     */
    public function __construct()
    {
        // apply metoduna erişim için auth middleware
        $this->middleware('auth');
    }

    /**
     * İş ilanına başvur.
     */
    public function apply(Request $request, $jobId)
    {
        $job = Job::findOrFail($jobId);

        // Kullanıcının zaten başvuru yapıp yapmadığını kontrol et
        $existingApplication = Application::where('user_id', Auth::id())
                                         ->where('job_id', $jobId)
                                         ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', __('You have already applied to this job.'));
        }

        // Doğrulama kuralları
        $request->validate([
            'cover_letter' => 'nullable|string',
        ]);

        // Başvuruyu oluştur
        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $job->id,
            'cover_letter' => $request->cover_letter,
        ]);

        return redirect()->route('jobs.show', $job->id)->with('success', __('Application submitted successfully!'));
    }
}
