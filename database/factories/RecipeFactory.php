<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nbIng = $this->faker->numberBetween(2, 4);
        $usersId = User::pluck("id")->toArray();
        return [
            "user_id" => $this->faker->randomElement($usersId),
            "title" => $this->faker->sentence(3),
            "description" => $this->faker->sentence(10),
            "instructions" => $this->faker->paragraphs(2, true),
            "ingredients" => json_encode(
                collect(range(1, $nbIng))->map(function () {
                    return [
                        'name' => fake()->words(2, true),
                        'quantity' => rand(1, 300),
                    ];
                })->toArray()
            ),
        ];
    }
}
