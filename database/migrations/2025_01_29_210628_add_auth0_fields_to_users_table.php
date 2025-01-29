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
        Schema::table('users', function (Blueprint $table) {
            $table->string('auth0_id')->nullable()->unique();
            $table->string('photo')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->boolean('email_verified')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['auth0_id', 'photo', 'country', 'city', 'email_verified']);
        });
    }
};
