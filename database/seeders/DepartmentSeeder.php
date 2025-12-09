<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'Junior High School', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Senior High School', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
