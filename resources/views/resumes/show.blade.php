@extends('layout.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Resume</div>

                <div class="card-body">
                    <h2>{{ $resume['personal_information']['name'] }} {{ $resume['personal_information']['surname'] }}</h2>
                    <p><strong>Заголовок:</strong> {{ $resume['title'] }}</p>
                    <p><strong>Статус:</strong> {{ $resume['status'] }}</p>
                    <p><strong>Опыт работы:</strong> {{ $resume['total_work_experience'] }}</p>
                    <p><strong>Зарплата:</strong> ${{ $resume['salary'] }} руб.</p>
                    <p><strong>График работы:</strong> {{ $resume['employment'] }}</p>
                    <p><strong>Тип занятости:</strong> {{ $resume['schedule'] }}</p>
                    <p><strong>Описание:</strong> {{ $resume['description'] }}</p>

                    <h3>Контактная информация</h3>
                    <p><strong>Номер телефона:</strong> {{ $resume['contact']['mobile_number'] }}</p>
                    <p><strong>Комментарий:</strong> {{ $resume['contact']['comment'] }}</p>
                    @if(!empty($resume['contact']['other_sources']['linkedin']))
                        <p><strong>LinkedIn:</strong> <a href="{{ $resume['contact']['other_sources']['linkedin'] }}">{{ $resume['contact']['other_sources']['linkedin'] }}</a></p>
                    @endif
                    @if(!empty($resume['contact']['other_sources']['telegram']))
                        <p><strong>Telegram:</strong> <a href="{{ $resume['contact']['other_sources']['telegram'] }}">{{ $resume['contact']['other_sources']['telegram'] }}</a></p>
                    @endif

                    <h3>Навыки</h3>
                    <ul>
                        @foreach ($resume['skills'] as $skill)
                            <li>{{ $skill['name'] }}</li>
                        @endforeach
                    </ul>

                    <h3>Специализации</h3>
                    <ul>
                        @foreach ($resume['specializations'] as $specialization)
                            <li>{{ $specialization['name'] }}</li>
                        @endforeach
                    </ul>

                    <h3>Опыт работы</h3>
                    @foreach ($resume['work_experiences'] as $experience)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $experience['position'] }}</h5>
                                <p class="card-text">{{ $experience['description'] }}</p>
                                <p><strong>Компания:</strong> {{ $experience['company_name'] }}</p>
                                <p><strong>Начало работы:</strong> {{ $experience['from'] }}</p>
                                <p><strong>Окончание:</strong> {{ $experience['to'] ?? 'Present' }}</p>
                            </div>
                        </div>
                    @endforeach

                    <h3>Образование</h3>
                    @foreach ($resume['education'] as $education)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $education['educational_institution']['name'] }}</h5>
                                <p class="card-text">{{ $education['degree'] }} in {{ $education['specialization'] }}</p>
                                <p><strong>Факультет:</strong> {{ $education['department'] }}</p>
                                <p><strong>Начало учебы:</strong> {{ $education['start_date'] }}</p>
                                <p><strong>Окончание:</strong> {{ $education['end_date'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
