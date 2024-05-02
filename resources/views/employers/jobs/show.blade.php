@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layout.app')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h1 class="display-4">{{ $job['title'] }}</h1>
                    <a class="h5 card-subtitle mb-2 text-muted"
                       href="{{ route('employers.show', ['employer' => $employer['id']]) }}">
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
                                <li class="list-group-item">
                                    График: {{ sprintf('%s, %s', $job['employment'], $job['schedule']) }}</li>
                                <li class="list-group-item">
                                    Расположение: {{ sprintf('%s, %s', $job['city']['city_with_country'], $job['street'])  }}</li>
                                <li class="list-group-item">Зарплата: {{ $job['salary'] }}</li>
                            </ul>
                            @if(!$job['is_archived'])
                                @if ($resumes->isNotEmpty())
                                    @auth('web.users')
                                        <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Откликнуться
                                        </button>
                                    @endauth
                                @endif

                                @guest('web.users')
                                    <a href="{{ route('users.auth.login-show') }}" class="btn btn-success mt-3">Войти
                                        для отклика</a>
                                @endguest
                            @endif

                            <a href="{{ route('jobs.index', ['page' => $previousPage]) }}" class="btn btn-primary mt-3">Назад
                                к вакансиям</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if((!$job['is_archived'] && Auth::guard('web.users')->check()) && ($resumes !== null && $resumes->isNotEmpty()))
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Откликнуться</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('employers.jobs.apply', ['job' => $job['id']]) }}" id="job-apply-form"
                              method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="resume">Резюме: @include('components.forms.is-required-mark')</label>
                                <select name="resume" id="resume"
                                        @class(['form-control', 'is-invalid' => $errors->has('resume')]) required>
                                    @foreach($resumes as $resume)
                                        <option @selected(old('resume') == $resume['id'])
                                                value="{{ $resume['id'] }}">{{ $resume['title'] }}</option>
                                    @endforeach
                                </select>
                                @include('components.forms.error', ['errorKey' => 'resume'])
                            </div>

                            <div class="form-group">
                                <label for="message">Сопроводительное
                                    письмо: @include('components.forms.is-required-mark')</label>
                                <textarea name="message"
                                          @class(['form-control', 'my-1', 'is-invalid' => $errors->has('message')]) id="message"
                                          rows="10" required
                                          placeholder="Сопроводительное письмо">{{ old('message') }}</textarea>
                                @include('components.forms.error', ['errorKey' => 'message'])
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" form="job-apply-form" class="btn btn-primary">Откликнуться</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
