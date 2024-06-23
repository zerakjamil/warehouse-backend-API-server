<?php

namespace Database\Factories\V1;

use App\Models\V1\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'warehouse_id' => Warehouse::factory()->create()->id,
            'profile_logo' => $this->faker->imageUrl(100, 100, 'business', true, 'Faker'),
            'address' => $this->faker->address(),
            'created_at' => $this->faker->dateTimeBetween('2020-1-1','now'),
        ];
    }
}
