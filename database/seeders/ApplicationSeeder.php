<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\User;
use App\Models\Job;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Kullanıcıları ve iş ilanlarını al
        $users = User::all();
        $jobs = Job::all();

        // Her kullanıcı için rastgele sayıda başvuru oluştur
        foreach ($users as $user) {
            // Kullanıcının kendi iş ilanlarına başvurmasını engelle
            $availableJobs = $jobs->where('user_id', '!=', $user->id);

            // Rastgele 3 iş ilanına başvur
            $applicableJobs = $availableJobs->random(min(3, $availableJobs->count()));

            foreach ($applicableJobs as $job) {
                // Zaten başvuru yapmadıysa
                $existingApplication = Application::where('user_id', $user->id)
                                                 ->where('job_id', $job->id)
                                                 ->first();
                if (!$existingApplication) {
                    Application::create([
                        'user_id' => $user->id,
                        'job_id' => $job->id,
                        'cover_letter' => 'CV',
                    ]);
                }
            }
        }
    }
}
