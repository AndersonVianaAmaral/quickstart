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
        $this->call(CategorySeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(CastMemberSeeder::class);
        $this->call(VideosSeeder::class);
    }
}
