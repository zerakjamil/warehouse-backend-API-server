<?php

namespace Database\Factories\V1;

use App\Models\V1\Branch;
use App\Models\V1\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'serial_number' => $this->faker->unique()->numerify('SN-########'),
            'mac_address' => $this->faker->macAddress(),
            'branch_id' => Branch::factory()->create()->id,
            'warehouse_id' => Warehouse::factory()->create()->id,
            'registered_at' => $this->faker->dateTimeBetween('2020-1-1','now'),
            'sold_at' => $this->faker->optional()->dateTimeBetween('2020-1-1','now'),
            'box_number' => $this->faker->numerify('BOX-#####'),
        ];
    }
}
