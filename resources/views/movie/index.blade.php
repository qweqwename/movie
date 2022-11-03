@extends('layouts.base')

@section('content')

    @include('includes.modal-alert')

    <div class="col-12 col-md-6">

        <a href="{{route('movie.create')}}" class="btn btn-success w-100 my-4 fw-bold text-uppercase">{{ __('+ Добавить фильм') }}</a>

        @foreach($movies as $key => $movie)

            {{--Вывести название группы фильмов--}}
            @if($movies[$key]->tag)
                @if(!array_key_exists($key - 1, $movies) || $movies[$key]->tag != $movies[$key - 1]->tag)
                    <h1 class="mb-4">
                        {{mb_convert_case($movie->tag ?? '', MB_CASE_TITLE, "UTF-8")}}

                        <form style="float: right" action="{{route('tag.destroy', $movie->tag_id)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-google w-100 btn-icon" aria-label="Google">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="4" y1="7" x2="20" y2="7"></line>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                            </button>
                        </form>
                    </h1>
                @endif
            @else
                @if(!array_key_exists($key - 1, $movies))
                    <h1 class="mb-4 text-danger">{{__('Без тегов')}}</h1>
                @endif
            @endif


            <div class="card mb-4">
                <div class="card-header">
                    <strong>{{$movie->title}}</strong>&nbsp;({{$movie->year}})
                </div>
                <div class="card-body my-0 py-2">
                    @foreach(explode(',', $movie->tags ?? '') as $tag)
                        <span class="badge bg-light text-dark p-2 m-1">{{$tag}}</span>
                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{route('movie.edit', ['id' => $movie->id])}}" class="btn btn-primary w-100">{{__('Редактировать')}}</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
