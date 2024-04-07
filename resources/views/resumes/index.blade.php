@extends('layout.app')

@section('content')
    <h1>Список резюме</h1>

    @foreach ($data as $resume)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $resume['title'] }}</h5>
                <p class="card-text">
                    <span class="badge bg-primary">{{ $resume['status'] }}</span><br>
                    <b>Занятость:</b> {{ $resume['employment'] }}<br>
                    <b>График:</b> {{ $resume['schedule'] }}<br>
                    <b>Опыт работы:</b> {{ $resume['total_work_experience'] }}<br>
                    <span class="salary"><b>Зарплата:</b> {{ $resume['salary'] }} руб.</span>
                </p>
                <a href="{{ route('resumes.show', ['resume' => $resume['id']]) }}" class="btn btn-primary">Показать</a>
            </div>
        </div>
    @endforeach

    {{ $data->links() }}
@endsection
