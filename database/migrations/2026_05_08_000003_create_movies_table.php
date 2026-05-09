<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->string('video_url', 500)->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['Phim lẻ', 'Phim bộ'])->default('Phim lẻ');
            $table->unsignedSmallInteger('year')->nullable();
            $table->decimal('rating', 3, 1)->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
