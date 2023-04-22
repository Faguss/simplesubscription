<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Subscriber;
use App\Models\Website;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Subscriber::factory(10)->create();
        Website::factory(3)->create();
        Post::factory(10)->create();

        for ($i = 0; $i < 5; $i++)
            DB::table('subscriber_website')->insert(
                [
                    'subscriber_id' => Subscriber::select('id')->orderByRaw("RAND()")->first()->id,
                    'website_id' => Website::select('id')->orderByRaw("RAND()")->first()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
    }
}
