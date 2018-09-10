@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('task.index', ['p_id' => $paragraph->id]) }}" class="btn btn-link px-0 mb-4 mt-1">Назад</a>
                <br>
                {!! Form::open(['route' => ['task.store', $paragraph->id], 'class' => 'd-block']) !!}
                <div class="form-group">
                    <label for="title">Добавить задание:</label>
                    <input type="text" name="title" id="task_title_id" class="form-control" placeholder="Введите название">
                </div>
                <button class="btn btn-success">Добавить</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection