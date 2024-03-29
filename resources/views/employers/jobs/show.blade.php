@extends('layout.app')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h1>{{ $job['title'] }}</h1>
{{--                    <a class="h5 card-subtitle mb-2 text-muted" href="{{ route('employers.show', ['employer' => $employer['id']]) }}">--}}
                    <a class="h5 card-subtitle mb-2 text-muted" href="#">
                        {{ $employer['name'] }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($job['is_archived'])
                            <p class="badge bg-danger fs-5">Архивная вакансия</p>
                        @endif
                        <div class="col-md-8">
                            <h5>Описание</h5>
                            <p class="card-text">{{ $job['description'] }}</p>
                            <h5>Квалификации и навыки</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    @foreach($job['skills'] as $skill)
                                        @include('components.jobs.skill-badge', ['skill' => $skill['name']])
                                    @endforeach
                                </li>
                                <li class="list-group-item">Образование: {{ $job['education'] }}</li>
                                <li class="list-group-item">Опыт работы: {{ $job['experience'] }}</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h5>Дополнительные детали</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">График: {{ sprintf('%s, %s', $job['employment'], $job['schedule']) }}</li>
                                <li class="list-group-item">Расположение: {{ sprintf('%s, %s', $job['city']['city_with_country'], $job['street'])  }}</li>
                                <li class="list-group-item">Зарплата: {{ $job['salary'] }}</li>
                            </ul>
                            @if(!$job['is_archived'])
                                @auth('web.users')
                                    <a href="#" class="btn btn-success mt-3">Откликнуться</a>
                                @endauth

                                @guest('web.users')
                                    <a href="#" class="btn btn-success mt-3">Войти для отклика</a>
                                @endguest
                            @endif

                            <a href="http://localhost?page={{ $previousPage }}" class="btn btn-primary mt-3">Назад к вакансиям</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
