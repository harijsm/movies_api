<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovieBroadcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = \App\Models\Movie::all();
        $channels = range(1, 10);

        foreach ($movies as $movie) {
            $broadcasts = [];

            for ($i = 0; $i < 15; $i++) {
                $broadcasts[] = [
                    'channel_nr' => $channels[array_rand($channels)],
                    'broadcasts_at' => now()->addDays(rand(1, 30))->addHours(rand(1, 24)),
                ];
            }

            $movie->broadcasts()->createMany($broadcasts);
        }
    }
}
