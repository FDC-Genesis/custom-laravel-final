<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Model\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // You can call other seeders here, for example:
        // $this->call(UserSeeder::class);
        Admin::factory()->count(10)->create();
    }
}
