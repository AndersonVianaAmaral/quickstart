<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Videos::factory()->count(10)->create();
    }
}
