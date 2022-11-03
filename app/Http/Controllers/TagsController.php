<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function destroy($id){
        if($tag = Tag::find($id)){
            $tag->delete();
            return redirect()->route('movie.index', $id)->with('modal',
                (object)[
                    'title' => 'Готово',
                    'content' => "Тег $tag->title удален",
                ]
            );
        }
    }
}
