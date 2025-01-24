<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Theater;
use App\Models\Screen;
use App\Models\Show;
use App\Models\Seat;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Genre
        $genre = Genre::create([
            'name' => 'Action',
            'description' => 'Action movies'
        ]);

        // Create Movie
        $movie = Movie::create([
            'title' => 'The Dark Knight',
            'description' => 'Batman fights crime in Gotham City',
            
            'release_date' => '2008-07-18',
            'genre_id' => $genre->id,
            'rating' => 9.0,
            'poster_image' => 'dark-knight.jpg',
            'trailer_url' => 'https://youtube.com/dark-knight'
        ]);

        // Create Theater
        $theater = Theater::create([
            'name' => 'Cineplex Downtown',
            'location' => '123 Main St',
            'capacity' => 300
        ]);

        // Create Screen
        $screen = Screen::create([
            'theater_id' => $theater->id,
            'name' => 'Screen 1',
            'seat_capacity' => 100
        ]);

        // Create Shows
        $show = Show::create([
            'movie_id' => $movie->id,
            'screen_id' => $screen->id,
            'show_time' => now()->addDays(1)->setHour(18)->setMinute(30),
            'price' => 12.99
        ]);

        // Create Seats
        for ($row = 'A'; $row <= 'J'; $row++) {
            for ($number = 1; $number <= 10; $number++) {
                Seat::create([
                    'screen_id' => $screen->id,
                    'seat_number' => $row . $number,
                    
                ]);
            }
        }
        

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            
            'role' => 'customer'
        ]);
    }
}