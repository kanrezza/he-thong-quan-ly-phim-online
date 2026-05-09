<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('avatar');
            $table->json('favorite_genres')->nullable()->after('bio');
            $table->text('favorite_movies')->nullable()->after('favorite_genres');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio', 'favorite_genres', 'favorite_movies']);
        });
    }
};
