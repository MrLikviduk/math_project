@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('task.index', ['p_id' => $paragraph->id]) }}" class="btn btn-link px-0 mb-4 mt-1">Назад</a>
                <br>
                {!! Form::open(['route' => ['task.update', $task->id], 'method' => 'put', 'class' => 'd-block']) !!}
                <div class="form-group">
                    <label for="title">Редактировать задание:</label>
                    <input type="text" name="title" id="task_title_id" class="form-control" value="{{ $task->title }}"
                           placeholder="Введите название">
                </div>
                <button class="btn btn-warning my-4">Изменить</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection