<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Tools'],
            ['id' => 2, 'name' => 'Electrical'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(['id' => $category['id']], $category);
        }
    }
}
