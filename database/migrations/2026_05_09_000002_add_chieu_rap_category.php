<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('categories')->insertOrIgnore([
            ['name' => 'Chiếu rạp', 'slug' => 'chieu-rap', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('categories')->where('slug', 'chieu-rap')->delete();
    }
};
