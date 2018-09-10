@extends('layouts.app')

@section('content')
    <div class="container">
        @can ('edit-article')
            <div class="row my-0">
                <a href="{{ route('p.create') }}">
                    <button class="btn btn-link">Добавить параграф</button>
                </a>
            </div>
        @endcan
        <div class="row my-4">
            <div class="col-md-10">
                @foreach($paragraphs as $paragraph)
                    <h2>
                        {{ $paragraph->title }}
                        @can ('edit-article')
                            <a href="{{ route('p.edit', ['id' => $paragraph->id]) }}">
                                <button class="btn btn-primary btn-sm">Редактировать</button>
                            </a>
                            {!! Form::open(['route' => ['p.destroy', $paragraph->id], 'method' => 'delete', 'class' => 'd-inline-block']) !!}
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Вы действительно хотите удалить параграф?')">Удалить
                            </button>
                            {!! Form::close() !!}
                            <br>
                        @endcan
                    </h2>
                    <div>
                        {!! $paragraph->body !!}
                        <br>
                        <a href="{{ route('task.index', ['p_id' => $paragraph->id]) }}" target="_blank">
                            <button class="btn btn-primary mb-2 mb-md-5">Проверь себя</button>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection