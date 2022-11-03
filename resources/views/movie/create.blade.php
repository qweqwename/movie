@extends('layouts.base')

@section('content')

    @include('includes.modal-alert')

    <div class="col-12 col-md-6">

        <a href="{{route('movie.index')}}" class="btn btn-primary my-4 fw-bold text-uppercase">{{ __('Назад') }}</a>

        <div class="card mb-4">
            <div class="card-header">
                <b>{{__('Добавить фильм')}}</b>
            </div>

            <form action="{{route('movie.store')}}" method="POST">
                @csrf
                <div class="card-body my-0 py-2">
                    @include('includes.card-alert')
                    <div class="mb-3">
                        <label for="" class="form-label">{{__('Название фильма:')}}</label>
                        <input value="" placeholder="{{__('Матрица')}}" type="text" name="title" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">{{__('Год выхода')}}:</label>
                        <input value="" placeholder="2022" type="number" name="year" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">{{__('Теги фильма')}}:</label>

                        <input id="tags" class="form-control" name='tags' value=''>
                    </div>
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-success w-100">{{__('Добавить')}}</button>
                </div>
            </form>
        </div>

    </div>

    <script>
        let input = document.querySelector('#tags');

        let whitelist = [@foreach($all_tags as $tag){!! '"'.$tag->title.'",' !!}@endforeach];

        let tagify = new Tagify(input, {
            whitelist:whitelist,
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0,
                closeOnSelect: false
            }
        })
    </script>
@endsection
