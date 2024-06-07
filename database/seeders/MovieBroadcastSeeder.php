<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieBroadcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $channels = 50;
        $movies = Movie::all();

        for($i = 1; $i <= $channels; $i++) {
            $moviesToBroadcast = $movies->random(rand(30, 50));
            $lastBroadcastTime = now()->addDays(rand(-5, 30))->addHours(rand(1, 24));

            foreach ($moviesToBroadcast as $movie) {
                if(!$movie->premieres_at || $movie->premieres_at->gt($lastBroadcastTime)) {
                    $movie->update([
                        'premieres_at' => $lastBroadcastTime,
                    ]);
                }

                $movie->broadcasts()->create([
                    'channel_nr' => $i,
                    'broadcasts_at' => $lastBroadcastTime,
                ]);

                $commercialBreakMinutes = rand(15, 35);
                $lastBroadcastTime = $lastBroadcastTime->addMinutes($movie->running_time + $commercialBreakMinutes);
            }
        }
    }
}
