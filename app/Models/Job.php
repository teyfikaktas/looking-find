<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobsP';

    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'position',
        'company',
        'description',
        'country',
        'city',
        'town',
        'working_preference',
        'images',  // Bunu ekleyelim

        // Diğer gerekli kolonlar
    ];

    /**
     * İş ilanını oluşturan kullanıcı.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * İş ilanına yapılan başvurular.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    public function randomImage()
    {
        $images = [
            'https://source.unsplash.com/300x200/?business',
            'https://source.unsplash.com/300x200/?office',
            'https://source.unsplash.com/300x200/?corporate',
            'https://source.unsplash.com/300x200/?career',
            'https://source.unsplash.com/300x200/?company',
        ];
        return $images[array_rand($images)];
    }
}
