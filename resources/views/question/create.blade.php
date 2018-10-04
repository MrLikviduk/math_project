@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('task.index', ['p_id' => $task->paragraph_id, 'id' => $task->id]) }}">Назад</a>
                <br>
                <br>
                {!! Form::open(['route' => ['question.store', $task->id]]) !!}
                <div class="form-group">
                    <label for="body">Название вопроса:</label>
                    <textarea name="body" id="question_title_id" rows="3" class="form-control"></textarea>
                </div>
                <button class="btn btn-success">Добавить</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection