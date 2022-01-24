<?php

namespace Database\Seeders;

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
        $this->call(PermissionSeeder::class);
        $this->call(ExpertiseSeeder::class);
        $this->call(DoctorsSeeder::class);
        $this->call(TestsSeeder::class);
    }
}
