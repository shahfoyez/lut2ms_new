<?php

namespace Database\Seeders;

use App\Models\Routex;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoutexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Routex::factory()->times(4)->create();
    }
}
