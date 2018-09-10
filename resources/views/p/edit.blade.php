@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="{{ route('p.index') }}" class="btn btn-link px-0 mb-4 mt-1">Назад</a>
                <br>
                {!! Form::open(['route' => ['p.update', $p->id], 'method' => 'put']) !!}
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="form-group">
                    <label for="title">Название:</label>
                    <input type="text" name="title" id="title_id" class="form-control" placeholder="Введите название" value="{{ old('title') ?? $p->title }}">
                </div>
                <div class="form-group">
                    <label for="body">Изменить параграф #{{ $p->id }}:</label>
                    <textarea name="body" id="body_id" cols="30" rows="30"
                              class="form-control" wrap="physical">{{ old('body') ?? $p->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-warning">Изменить</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection