<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index(){
        //Получить фильмы сгрупированные по тегам и теги к фильмам
        $movies = DB::select("SELECT i.title, i.year, i.tag, i.id, i.tag_id, REPLACE(REPLACE(TRIM(REPLACE(g.items, i.title, '')), ' ', ' '), ' ', ', ') AS tags FROM (SELECT movies.id AS id, movies.title AS title, movies.year AS year, tags.title AS tag, tags.id AS tag_id FROM movies LEFT JOIN movies_tags ON movies.id = movies_tags.movie_id LEFT JOIN tags ON tags.id = movies_tags.tag_id) AS i INNER JOIN (SELECT z.title, GROUP_CONCAT(z.tag SEPARATOR ',') AS items FROM (SELECT movies.id AS id, movies.title AS title, movies.year AS year, tags.title AS tag, tags.id AS tag_id FROM movies LEFT JOIN movies_tags ON movies.id = movies_tags.movie_id LEFT JOIN tags ON tags.id = movies_tags.tag_id) AS z GROUP BY z.title) g ON g.title = i.title ORDER BY i.tag");
        return view('movie.index', compact('movies'));
    }

    public function edit($id){
        if($movie = Movie::find($id)){

            //Получить все теги, которые есть на сайте
            $all_tags = Tag::all();

            //Получить теги, принадлежащие фильму
            $movie_tags = DB::table('movies_tags')
                ->leftJoin('tags', 'movies_tags.tag_id', '=', 'tags.id')
                ->where('movies_tags.movie_id', '=', $id)
                ->get();

            return view('movie.edit', compact(['movie', 'all_tags', 'movie_tags']));
        } else {
            return redirect()->route('movie.index');
        }
    }

    public function create(){

        //Получить все теги, которые есть на сайте
        $all_tags = Tag::all();

        return view('movie.create', compact(['all_tags']));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|max:255',
            'year' => 'required|numeric|max:100000|min:1',
            'tags' => 'nullable|json',
        ]);

        //Получаем ID тегов и создаем новые теги, если их нет
        $tags_ids = [];
        if($tags_json = json_decode($request->input('tags'), true)){
            $tags_titles = [];
            foreach ($tags_json as $value){
                $tags_titles[] = $value['value'];
            }
            foreach ($tags_titles as $tag){
                $tags_ids[] = Tag::firstOrCreate(['title' => $tag])->id;
            }
        }

        //Добавляем фильм в БД
        $id = DB::table('movies')->insertGetId([
            'title' => $request->input('title'),
            'year' => $request->input('year'),
        ]);

        //Сохраняем теги к фильму
        Movie::find($id)->tags()->sync($tags_ids);

        return redirect()->route('movie.index', $id)->with('modal',
            (object)[
                'title' => 'Готово',
                'content' => "Фильм добавлен",
            ]
        );
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'title' => 'required|max:255',
            'year' => 'required|numeric|max:100000|min:1',
            'tags' => 'nullable|json',
        ]);

        //Получаем ID тегов и создаем новые теги, если их нет
        $tags_ids = [];
        if($tags_json = json_decode($request->input('tags'), true)){
            $tags_titles = [];
            foreach ($tags_json as $value){
                $tags_titles[] = $value['value'];
            }
            foreach ($tags_titles as $tag){
                $tags_ids[] = Tag::firstOrCreate(['title' => $tag])->id;
            }
        }

        if($movie = Movie::find($id)){

            //Сохраняем теги к фильму
            $movie->tags()->sync($tags_ids);

            //Сохраняем название и год
            DB::table('movies')
                ->where('id', '=', $id)
                ->update([
                    'title' => $request->input('title'),
                    'year' => $request->input('year'),
                ]);

            return redirect()->route('movie.edit', $id)->with('modal',
                (object)[
                    'title' => 'Готово',
                    'content' => 'Изменения сохранены',
                ]
            );
        }
    }

    public function destroy($id){
        if($movie = Movie::find($id)){
            $movie->delete();
            return redirect()->route('movie.index', $id)->with('modal',
                (object)[
                    'title' => 'Готово',
                    'content' => "Фильм $movie->title удален",
                ]
            );
        }
    }
}
