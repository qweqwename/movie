<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('movies')->truncate();
        DB::table('tags')->truncate();
        DB::table('movies_tags')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('users')->insert([
            'name' => 'qwe',
            'email' => 'qweqwename@gmail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('tags')->insert([
            'title' => "драма",
        ]);
        DB::table('tags')->insert([
            'title' => "детектив",
        ]);
        DB::table('tags')->insert([
            'title' => "боевик",
        ]);

        $movie = new Movie();
        $movie->title = "Побег из Шоушенка";
        $movie->year = 1994;
        $movie->save();
        $movie->tags()->sync([1]);


        $movie = new Movie();
        $movie->title = "Крёстный отец";
        $movie->year = 1972;
        $movie->save();
        $movie->tags()->sync([2, 1]);


        $movie = new Movie();
        $movie->title = "Тёмный рыцарь";
        $movie->year = 2008;
        $movie->save();
        $movie->tags()->sync([2, 1, 3]);

        $movie = new Movie();
        $movie->title = "Крёстный отец 2";
        $movie->year = 1974;
        $movie->save();
        $movie->tags()->sync([2, 1]);

        $movie = new Movie();
        $movie->title = "12 разгневанных мужчин";
        $movie->year = 1957;
        $movie->save();
        $movie->tags()->sync([2, 1]);

        // \App\Models\User::factory(10)->create();
    }
}
