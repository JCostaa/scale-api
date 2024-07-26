<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cycle::create([
            'name' => 'c0'
        ]);

        Cycle::create([
            'name' => 'c1'
        ]);
        Cycle::create([
            'name' => 'c2'
        ]);
        Cycle::create([
            'name' => 'c3'
        ]);
    }
}
