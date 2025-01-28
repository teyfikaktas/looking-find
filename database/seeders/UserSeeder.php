<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Örnek kullanıcılar oluştur
        User::create([
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet@example.com',
            'password' => Hash::make('Password123!'),
            'country' => 'Türkiye',
            'city' => 'İstanbul',
            'photo' => null, // Fotoğraf yüklemek isterseniz burada belirtin
        ]);

        User::create([
            'name' => 'Mehmet Demir',
            'email' => 'mehmet@example.com',
            'password' => Hash::make('Password123!'),
            'country' => 'Türkiye',
            'city' => 'Ankara',
            'photo' => null,
        ]);

        // Daha fazla kullanıcı ekleyebilirsiniz
    }
}
