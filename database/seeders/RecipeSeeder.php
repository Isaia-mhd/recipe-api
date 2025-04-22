<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::factory()->count(50)->create()->each(function ($recipe) {
            $categoryIds = Category::inRandomOrder()->take(1)->pluck('id');
            $recipe->categories()->sync($categoryIds);
        });
    }
}
