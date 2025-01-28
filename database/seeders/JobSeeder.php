<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\User;
use Faker\Factory as Faker;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('tr_TR'); // Türkçe veriler için

        // Kullanıcıları al
        $users = User::all();

        // Her kullanıcı için 5 iş ilanı oluştur
        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                Job::create([
                    'user_id' => $user->id,
                    'position' => $faker->jobTitle,
                    'company' => $faker->company,
                    'description' => $faker->paragraph(4),
                    'country' => $user->country,
                    'city' => $user->city,
                    'town' => $faker->citySuffix,
                    'working_preference' => ['remote', 'on-site', 'hybrid'],
                ]);
            }
        }
    }
}
