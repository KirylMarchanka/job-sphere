@php use Carbon\Carbon; @endphp
@extends('layout.app')

@section('content')
    <div class="col-12">
        <div class="row">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($applies as $apply)
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('users.resumes.show', ['resume' => $apply['resume']['id']]) }}">{{ $apply['resume']['title'] }}</a>
                                    -
                                    <a href="{{ route('employers.jobs.show', ['employer' => $apply['employer_job']['employer_id'], 'job' => $apply['employer_job']['id']]) }}">{{ $apply['employer_job']['title'] }}</a>
                                </h5>
                                <p class="card-text">
                                    <b>Статус:</b> {{ $apply['status'] }}<br>
                                    <b>Дата:</b> {{ Carbon::parse($apply['created_at'])->format('Y-m-d H:i') }}<br>
                                    <b>Тип:</b>
                                    @if ($apply['type'] === 0)
                                        Приглашение
                                    @else
                                        Отклик
                                    @endif
                                    <br>
                                    <b>Зарплата:</b> {{ $apply['employer_job']['salary'] }}
                                </p>
                                <a href="{{ route('users.invites-and-applies.show', ['apply' => $apply['id']]) }}" class="btn btn-primary">Детали</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
