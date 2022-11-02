<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(RoutexSeeder::class);
        $this->call(StoppageSeeder::class);
        $this->call(VehicleTypeSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(EmployeeSeeder::class);
    }
}
