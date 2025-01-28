<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 // database/migrations/xxxx_xx_xx_xxxxxx_add_fields_to_users_table.php

public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('country')->after('email');
        $table->string('city')->after('country');
        $table->string('photo')->nullable()->after('city');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['country', 'city', 'photo']);
    });
}

};
