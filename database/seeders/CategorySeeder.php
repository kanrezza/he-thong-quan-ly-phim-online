<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hành động',  'slug' => 'hanh-dong'],
            ['name' => 'Tâm lý',     'slug' => 'tam-ly'],
            ['name' => 'Tình cảm',   'slug' => 'tinh-cam'],
            ['name' => 'Kinh dị',    'slug' => 'kinh-di'],
            ['name' => 'Hài',        'slug' => 'hai'],
            ['name' => 'Hoạt hình',  'slug' => 'hoat-hinh'],
            ['name' => 'Viễn tưởng', 'slug' => 'vien-tuong'],
            ['name' => 'Phim bộ',    'slug' => 'phim-bo'],
            ['name' => 'Cổ trang',   'slug' => 'co-trang'],
            ['name' => 'Tội phạm',   'slug' => 'toi-pham'],
            ['name' => 'Chiếu rạp',  'slug' => 'chieu-rap'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
