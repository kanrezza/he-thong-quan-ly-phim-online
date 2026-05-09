<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('country')->nullable()->after('year');
            $table->text('actors')->nullable()->after('country');
            $table->dropForeign(['category_id']);
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });

        Schema::create('category_movie', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->primary(['category_id', 'movie_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_movie');
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['country', 'actors']);
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }
};
