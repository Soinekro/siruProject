<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            ProvinceSeeder::class,
            DistritSeeder::class,
            District2Seeder::class,
        ]);
        \App\Models\Enterprise::factory(20)->create();
        \App\Models\User::factory(100)->create();
    }
}
