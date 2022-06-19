<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ShortUrls\Database\Seeders\ShortUrlSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ShortUrlSeeder::class);
    }
}
