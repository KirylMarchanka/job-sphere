@php use Carbon\Carbon; @endphp
@extends('layout.app')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <h1 class="display-4 mb-4">Резюме: {{ $resume['title'] }}</h1>

            <div class="row">
                <div class="col-sm-6">
                    <p class="lead">ФИО:</p>
                    <p>{{ sprintf('%s %s %s', $resume['personal_information']['name'], $resume['personal_information']['surname'], $resume['personal_information']['middle_name']) }}</p>
                </div>

                <div class="col-sm-6">
                    <p class="lead">Статус:</p>
                    <p>{{ $resume['status'] }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <p class="lead">Дата рождения:</p>
                    <p>{{ Carbon::parse($resume['personal_information']['birthdate'])->isoFormat('D MMMM YYYY') }}</p>
                </div>

                <div class="col-sm-6">
                    <p class="lead">Пол:</p>
                    <p>{{ $resume['personal_information']['sex'] === 'm' ? 'Мужчина' : 'Женщина' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p class="lead">Город:</p>
                    <p>{{ $resume['personal_information']['city']['city_with_country'] }}</p>
                </div>
            </div>

            <h1 class="display-5">Рабочая информация</h1>

            <div class="row">
                <div class="col-sm-6">
                    <p class="lead">Опыт работы:</p>
                    <p>{{ $resume['total_work_experience'] }}</p>
                </div>

                <div class="col-sm-6">
                    <p class="lead">Зарплата:</p>
                    <p>{{ $resume['salary'] }} руб.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <p class="lead">График работы:</p>
                    <p>{{ $resume['employment'] }}</p>
                </div>

                <div class="col-sm-6">
                    <p class="lead">Тип занятости:</p>
                    <p>{{ $resume['schedule'] }}</p>
                </div>
            </div>

            <h1 class="display-5">Контактная информация</h1>

            <div class="row">
                <div class="col-sm-3">
                    <p class="lead">Номер телефона:</p>
                    <a href="tel:{{ $resume['contact']['mobile_number'] }}">{{ $resume['contact']['mobile_number'] }}</a>
                </div>

                <div class="col-sm-3">
                    <p class="lead">Почта:</p>
                    <a href="mailto:{{ $resume['contact']['email'] }}">{{ $resume['contact']['email'] }}</a>
                </div>

                @if(!empty($resume['contact']['other_sources']['linkedin']))
                    <div class="col-sm-3">
                        <p class="lead">LinkedIn:</p>
                        <a href="{{ $resume['contact']['other_sources']['linkedin'] }}">{{ $resume['contact']['other_sources']['linkedin'] }}</a>
                    </div>
                @endif

                @if(!empty($resume['contact']['other_sources']['telegram']))
                    <div class="col-sm-3">
                        <p class="lead">Telegram:</p>
                        <a href="{{ $resume['contact']['other_sources']['telegram'] }}">{{ $resume['contact']['other_sources']['telegram'] }}</a>
                    </div>
                @endif

                <div class="col-sm-3">
                    <p class="lead">Предпочитаемый способ связи:</p>
                    <p>{{ $resume['contact']['preferred_contact_source'] }}</p>
                </div>

                <div class="col-sm-3">
                    <p class="lead">Комментарий:</p>
                    <p>{{ $resume['contact']['comment'] }}</p>
                </div>
            </div>

            <h1 class="display-5">Навыки и специализации</h1>

            <div class="row">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        @foreach($resume['skills'] as $skill)
                            @include('components.jobs.skill-badge', ['skill' => $skill['name']])
                        @endforeach
                    </li>

                    <li class="list-group-item">
                        @foreach($resume['specializations'] as $specialization)
                            @include('components.jobs.skill-badge', ['skill' => $specialization['name']])
                        @endforeach
                    </li>
                </ul>
            </div>

            <h1 class="display-5">Описание</h1>

            <div class="row">
                <div class="col-12">
                    <p>{{ $resume['description'] }}</p>
                </div>
            </div>

            <h1 class="display-5">Опыт работы</h1>
            @foreach ($resume['work_experiences'] as $experience)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $experience['position'] }}</h5>
                        <p class="card-text">{{ $experience['description'] }}</p>
                        <p><strong>Компания:</strong> {{ $experience['company_name'] }}</p>
                        <strong>Сайт компании:</strong> <a href="{{ $experience['site_url'] ?? '#' }}">{{ $experience['site_url'] ?? '-' }}</a>
                        <p><strong>Город:</strong> {{ $experience['city']['city_with_country'] }}</p>
                        <p><strong>Начало работы:</strong> {{ $experience['from'] }}</p>
                        <p><strong>Окончание:</strong> {{ $experience['to'] ?? 'Present' }}</p>
                    </div>
                </div>
            @endforeach

            <h1 class="display-5">Образование</h1>
            @foreach ($resume['education'] as $education)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $education['educational_institution']['name'] }}</h5>
                        <p class="card-text">{{ $education['degree'] }} в {{ $education['specialization'] }}</p>
                        <p><strong>Город:</strong> {{ $experience['city']['city_with_country'] }}</p>
                        <p><strong>Факультет:</strong> {{ $education['department'] }}</p>
                        <p><strong>Начало учебы:</strong> {{ $education['start_date'] }}</p>
                        <p><strong>Окончание:</strong> {{ $education['end_date'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
