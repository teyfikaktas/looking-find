<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jobsP', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // İş ilanını oluşturan kullanıcı (işveren)
            $table->string('position');
            $table->string('company');
            $table->text('description');
            $table->string('country');
            $table->string('city');
            $table->string('town')->nullable(); // Opsiyonel
            $table->enum('working_preference', ['remote', 'on-site', 'hybrid']);
            $table->timestamps();
    
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobsP');
    }
};
