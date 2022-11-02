<?php

namespace Database\Seeders;

use App\Models\Stoppage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoppageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stoppage::factory()->times(30)->create();
    }
}
