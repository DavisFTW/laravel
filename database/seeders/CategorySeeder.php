<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'IT'],
            ['name' => 'Economics'],
            ['name' => 'Politics'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
