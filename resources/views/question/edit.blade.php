@extends('layouts.app')

@section('content')
    <script>
        function add_answer() {
            $('textarea').each(function () {
                var id_nic = $(this).attr('id');
                var nic = nicEditors.findEditor(id_nic);
                if (nic) nic.saveContent();
            });
            console.log($("#answer_form").serialize());
            $.ajax({
                type: 'POST',
                url: '{{ route('answer.store', ['id' => $question->id]) }}',
                data: $("#answer_form").serialize(),
                success: function (data) {
                    $("#answers").html(
                        $("#answers").html() + '<li>' +
                        data.body + ' ' + (data.is_right == 1 ? '<span class="text-success">Ответ верный</span>' : '') +
                        '</li>'
                    );
                }
            })
        }
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('task.index', ['p_id' => $task->paragraph_id, 'id' => $task->id]) }}">Назад</a>
                <br>
                <br>
                {!! Form::open(['route' => ['question.update', $question->id], 'method' => 'put']) !!}
                <div class="form-group">
                    <label for="body">Название вопроса:</label>
                    <textarea name="body" id="question_title_id" rows="3" class="form-control">{!! old('body') ?? $question->body !!}</textarea>
                </div>
                <button class="btn btn-warning">Изменить</button>
                {!! Form::close() !!}
                <h4 class="mt-4">Ответы:</h4>
                {!! Form::open(['id' => 'answer_form', 'class' => 'my-5']) !!}
                <textarea name="body" id="answer_title_id" cols="40" rows="2" class="form-control"></textarea>
                <label for="is_right">Ответ верный:</label>
                <input type="checkbox" name="is_right" value="1">
                <br>
                <button type="button" class="btn btn-primary my-1" onclick="add_answer()">Добавить ответ</button>
                {!! Form::close() !!}
                <ul id="answers">
                    @foreach($question->answers as $answer)
                        <li>
                            {!! $answer->body !!}
                            @if ($answer->is_right == 1)
                                <span class="text-success">Ответ верный</span>
                            @endif
                            {!! Form::open(['route' => ['answer.destroy', $answer->id], 'method' => 'delete', 'class' => 'd-inline-block']) !!}
                            <button class="btn btn-danger btn-sm py-0"
                                    onclick="return confirm('Вы действительно хотите удалить ответ?')">Удалить
                            </button>
                            {!! Form::close() !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection