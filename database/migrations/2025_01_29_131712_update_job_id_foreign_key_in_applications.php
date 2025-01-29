<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            // Önce eski foreign key'i kaldır
            $table->dropForeign(['job_id']);
            
            // Yeni foreign key'i doğru tablo adıyla ekle
            $table->foreign('job_id')
                  ->references('id')
                  ->on('jobsP')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            
            // Eski haline geri döndür
            $table->foreign('job_id')
                  ->references('id')
                  ->on('jobs')
                  ->onDelete('cascade');
        });
    }
};