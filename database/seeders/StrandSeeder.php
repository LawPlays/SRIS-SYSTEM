<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('strands')->insert([
            ['name' => 'STEM', 'department_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ABM',  'department_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HUMSS','department_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'GAS',  'department_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TVL',  'department_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
