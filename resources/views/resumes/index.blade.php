@extends('layout.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row mt-3">

        <div class="col-md-3">
            <h4 class="my-3">Поиск Резюме</h4>

            <form action="{{ route('resumes.index') }}">
                <div class="form-group">
                    <label for="title">Название:</label>
                    <input type="text" id="title" name="title" class="form-control my-1"
                           value="{{ old('title', $data['title'] ?? '') }}" placeholder="Введите название вакансии">
                </div>

                <div class="form-group">
                    <label for="salary_from">Зарплата от:</label>
                    <input type="number" min="1" step="1" id="salary_from" name="salary_from" class="form-control my-1"
                           value="{{ old('salary_from', $data['salary_from'] ?? null) }}" placeholder="Минимальная зарплата">
                </div>

                <div class="form-group">
                    <label for="salary_to">Зарплата до:</label>
                    <input type="number" min="1" step="1" id="salary_from" name="salary_to" class="form-control my-1"
                           value="{{ old('salary_to', $data['salary_to'] ?? null) }}" placeholder="Максимальная зарплата">
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" @checked($data['isset_salary'] ?? false) @class(['form-check-input', 'is-invalid' => $errors->has('isset_salary')]) name="isset_salary" id="isset_salary">
                    <label class="form-check-label" for="isset_salary">Указана зарплата</label>
                </div>

                <div class="form-group">
                    <label for="years_from">Возраст от:</label>
                    <input type="number" id="years_from" name="years_from" class="form-control my-1"
                           value="{{ old('years_from', $data['years_from'] ?? null) }}" placeholder="Возраст от">
                </div>

                <div class="form-group">
                    <label for="years_to">Возраст до:</label>
                    <input type="number" id="years_to" name="years_to" class="form-control my-1"
                           value="{{ old('years_to', $data['years_to'] ?? null) }}" placeholder="Возраст до">
                </div>

                <div class="form-group">
                    <label for="work_experience">Опыт работы (Месяцев):</label>
                    <input type="number" id="work_experience" name="work_experience" class="form-control my-1"
                           value="{{ old('work_experience', $data['work_experience'] ?? null) }}" placeholder="Опыт работы">
                </div>

                <div class="form-group">
                    <label for="city">Город:</label>
                    <select name="city[]" id="city" multiple class="form-select my-1">
                        <option value="">Любой</option>
                        @foreach ($cities as $city)
                            <option
                                @selected(in_array($city['id'], old('city', $data['city'] ?? []))) value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="schedule">Тип занятости:</label>
                    <select name="schedule" id="schedule" class="form-select my-1">
                        <option value="">Любой</option>
                        @foreach ($schedule as $id => $value)
                            <option
                                @selected($id == old('schedule', $data['schedule'] ?? -1)) value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="employment">График работы:</label>
                    <select name="employment" id="employment" class="form-select my-1">
                        <option value="">Любой</option>
                        @foreach($employment as $value => $text)
                            <option  @selected($id == old('employment', $data['employment'] ?? -1))
                                     value="{{ $value }}">{{ $text }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="skills">Навыки:</label>
                    <select name="skills[]" id="skills" class="form-select" multiple aria-label="Skills">
                        <option value="">Любые</option>
                        @foreach ($skills as $skill)
                            <option @selected(in_array($skill['id'], old('skills', $data['skills'] ?? []))) value="{{ $skill['id'] }}">{{ $skill['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-2">Найти</button>
                <a href="{{ route('resumes.index') }}" class="btn btn-secondary mt-2">Сбросить</a>
            </form>
        </div>

        <div class="col-md-9">
            <h1 class="display-4">Резюме</h1>

            @forelse ($resumes as $resume)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $resume['title'] }}</h5>
                        <p class="card-text">
                            <span class="badge bg-primary">{{ $resume['status'] }}</span><br>
                            <b>Занятость:</b> {{ $resume['employment'] }}<br>
                            <b>График:</b> {{ $resume['schedule'] }}<br>
                            <b>Опыт работы:</b> {{ $resume['total_work_experience'] }}<br>
                            <span class="salary"><b>Зарплата:</b> {{ $resume['salary'] !== null ? $resume['salary'] . ' руб.' : 'Не указано' }}</span>
                        </p>
                        <a href="{{ route('resumes.show', ['resume' => $resume['id']]) }}"
                           class="btn btn-primary">Показать</a>
                    </div>
                </div>
                @empty
                    <div class="card-header">Нет резюме</div>
                    <div class="card-body">
                        <p>Резюме по вашим параметрам не найдены.</p>
                    </div>
                @endforelse
        </div>
    </div>



    {{ $resumes->links() }}
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#skills').select2({
                maximumSelectionLength: 10,
                placeholder: "Выберите до 10 навыков"
            });

            $('#city').select2({
                maximumSelectionLength: 10,
                placeholder: "Выберите город"
            });
        });
    </script>
@endsection
