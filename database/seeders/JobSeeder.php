<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\User;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Rastgele Türkçe değerler için diziler
        $turkishCompanies = ['Arçelik', 'Vestel', 'Turkcell', 'THY', 'Koç Holding', 'Sabancı Holding'];
        $turkishDescriptions = [
            'Yenilikçi projeler üzerinde çalışıyoruz.',
            'Müşteri memnuniyeti odaklı bir şirketiz.',
            'Teknoloji ve inovasyon alanında lideriz.',
            'Global pazarda rekabetçi çözümler sunuyoruz.',
        ];
        $turkishTowns = ['Merkez', 'Köy', 'Kasaba', 'Mahalle', 'Semt'];

        // Kullanıcıları al
        $users = User::all();

        // Her kullanıcı için 5 iş ilanı oluştur
        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                Job::create([
                    'user_id' => $user->id,
                    'position' => 'Yazılım Geliştirici', // Örnek pozisyon
                    'company' => $turkishCompanies[array_rand($turkishCompanies)], // Rastgele Türkçe şirket adı
                    'description' => $turkishDescriptions[array_rand($turkishDescriptions)], // Rastgele Türkçe açıklama
                    'country' => $user->country,
                    'city' => $user->city,
                    'town' => $turkishTowns[array_rand($turkishTowns)], // Rastgele Türkçe town değeri
                    'working_preference' => 'remote' // JSON formatına dönüştürüldü
                ]);
            }
        }
    }
}