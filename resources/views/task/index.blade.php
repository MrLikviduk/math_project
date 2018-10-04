@extends('layouts.app')

@section('content')
    <script>
        function getMessage(task_id) {
            $.ajax({
                type: 'POST',
                url: '/getmsg',
                data: $("#questions" + task_id).serialize(),
                success: function (data) {
                    var msg = $("#msg" + task_id);
                    msg.html('Количество правильных ответов: ' + data.count_right + '/' + data.count_questions);
                    var p = data.count_right / data.count_questions * 100;
                    msg.removeClass("bg-success bg-warning bg-danger text-white text-dark");
                    msg.removeClass("d-none");
                    if (p >= 75) {
                        msg.addClass("bg-success text-white");
                    }
                    else if (p >= 30) {
                        msg.addClass("bg-warning text-dark");
                    }
                    else
                        msg.addClass("bg-danger text-white");
                }
            });
        }
    </script>
    <div class="container">
        <div class="row my-4">
            <div class="col-md-12">
                <a href="{{ route('p.index') }}" class="btn btn-link px-0 mb-1 mt-1">Назад</a>
                <h2 class="text-center">Задания по теме "{{ $paragraph->title }}"</h2>
                @can ('edit-article')
                    <a href="{{ route('task.create', $paragraph->id) }}">Добавить задание</a>
                @endcan
                @if (count($paragraph->tasks) == 0)
                    <h3 class="text-center my-5">К сожалению, сейчас нет заданий для самопроверки...</h3>
                @endif
                @foreach ($paragraph->tasks as $task)
                    <div class="card my-4">
                        <div class="card-header">
                            <span>{{ $task->title }}</span>
                            @can ('edit-article')
                                <a href="{{ route('task.edit', ['p_id' => $paragraph->id, 'id' => $task->id]) }}">
                                    <button class="btn btn-primary btn-sm mx-2">Редактировать</button>
                                </a>
                                {!! Form::open(['route' => ['task.destroy', $task->id], 'method' => 'delete', 'class' => 'd-inline-block']) !!}
                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Вы действительно хотите удалить задание?')">Удалить
                                </button>
                                {!! Form::close() !!}
                                <br>
                            @endcan
                        </div>
                        <div class="card-body">
                            @can ('edit-article')
                                <a href="{{ route('question.create', ['id' => $task->id]) }}">Добавить вопрос</a>
                                <br>
                            @endcan
                            @foreach ($task->questions->shuffle()->values() as $q_num => $question)
                                {!! Form::open(['id' => 'questions'.$task->id]) !!} {!! Form::close() !!}
                                {{ $q_num + 1 }}. {!! $question->body !!}
                                @can ('edit-article')
                                    <a href="{{ route('question.edit', ['id' => $question->id]) }}">
                                        <button class="btn btn-primary btn-sm mx-2 py-0" type="button">Редактировать
                                        </button>
                                    </a>
                                    {!! Form::open(['route' => ['question.destroy', $question->id], 'method' => 'delete', 'class' => 'd-inline-block']) !!}
                                    <button class="btn btn-danger btn-sm py-0"
                                            onclick="return confirm('Вы действительно хотите удалить вопрос?')">Удалить
                                    </button>
                                    {!! Form::close() !!}
                                @endcan
                                <br>
                                <ul class="m-0 mb-2 py-2" id="answers{{ $question->id }}">

                                    @foreach ($question->answers->shuffle() as $ans_num => $answer)
                                        <li><input type="{{ count($question->right_answers) > 1 ? 'checkbox' : 'radio' }}" name="ans[{{ $question->id }}][]"
                                                   value="{{ $answer->id }}"
                                                   form="questions{{ $task->id }}"> {!! $answer->body !!}</li>
                                    @endforeach

                                </ul>
                            @endforeach
                            <div id="msg{{ $task->id }}" class="p-3 rounded d-none"></div>
                            {!! Form::button('Проверить ответы', ['onClick' => 'getMessage('.$task->id.')', 'class' => 'btn btn-primary mt-2']) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection