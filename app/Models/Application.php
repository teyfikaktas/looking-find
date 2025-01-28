<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * Toplu atamaya izin verilen alanlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'job_id',
        'cover_letter',
    ];

    /**
     * Başvuruyu yapan kullanıcı.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Başvurulan iş ilanı.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
