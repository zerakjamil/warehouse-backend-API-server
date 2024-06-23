<?php

namespace Database\Seeders;

use App\Models\V1\Branch;
use App\Models\V1\Device;
use App\Models\V1\User;
use App\Models\V1\Warehouse;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Warehouse::factory(10)->create();
        Branch::factory(100)->create();
        Device::factory(3000)->create();
    }
}
