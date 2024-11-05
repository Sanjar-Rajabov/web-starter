<?php

namespace Database\Factories;

use App\Helpers\LocaleHelper;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;
        return [
            'name' => LocaleHelper::localize($name),
            'image' => 'uploads/categories/' . Str::random(20) . '.jpg',
            'icon' => 'uploads/categories/' . Str::random(20) . '.jpg',
            'position' => rand(1, 15),
            'show_on_home_page' => $this->faker->boolean(70),
            'is_published' => $this->faker->boolean(90),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
