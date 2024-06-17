<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Food & Drinks', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Housing', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Shopping', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Transport', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Vehicle', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Medicine', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Education', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Travels', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Entertainment', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Investments', 'type' => Category::TYPE_EXPENSE],
            ['name' => 'Other', 'type' => Category::TYPE_EXPENSE],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
