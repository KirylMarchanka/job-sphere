@php use Carbon\Carbon; @endphp
@extends('layout.app')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <h1 class="display-4">Резюме</h1>

            @forelse ($resumes as $resume)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $resume['title'] }}</h5>
                        <p class="card-text">
                            <span class="badge bg-primary">{{ $resume['status'] }}</span><br>
                            <b>Обновлено:</b> {{ Carbon::parse($resume['updated_at'])->format('Y-m-d H:i:s') }}<br>
                        </p>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.resumes.show', ['resume' => $resume['id']]) }}"
                               class="btn btn-primary">Показать</a>

                            <form action="{{ route('users.resumes.delete', ['resume' => $resume['id']]) }}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button class="btn btn-danger d-inline-block">Удалить</button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="card-header">Нет резюме</div>
                <div class="card-body">
                    <a class="btn btn-primary" href="{{ route('users.resumes.create') }}">Создать</a>
                </div>
            @endforelse

            @if(!empty($resumes))
                <div class="d-flex mb-3">
                    <a class="btn btn-primary" href="{{ route('users.resumes.create') }}">Создать</a>
                </div>
            @endif
        </div>
@endsection
