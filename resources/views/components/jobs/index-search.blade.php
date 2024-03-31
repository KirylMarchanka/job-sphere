<h4 class="my-3">Поиск вакансий</h4>
<form action="{{ route('jobs.index') }}">
    <div class="form-group">
        <label for="title">Название:</label>
        <input type="text" id="title" name="title" class="form-control my-1"
               value="{{ old('title', $data['title'] ?? '') }}" placeholder="Введите название вакансии">
    </div>

    <div class="form-group">
        <label for="sector">Сектор:</label>
        <select name="sector" id="sector" class="form-select my-1">
            <option value="">Любой</option>
            @foreach ($sectors as $sector)
                <option
                    @selected($sector['id'] == old('sector', $data['sector'] ?? 0)) value="{{ $sector['id'] }}">{{ $sector['name'] }}</option>
            @endforeach
        </select>
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

    <div class="form-group">
        <label for="city">Город:</label>
        <select name="city" id="city" class="form-select my-1">
            <option value="">Любой</option>
            @foreach ($cities as $city)
                <option
                    @selected($city['id'] == old('city', $data['city'] ?? 0)) value="{{ $city['id'] }}">{{ $city['name'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="education">Образование:</label>
        <select name="education" id="education" class="form-select my-1">
            <option value="">Любое</option>
            @foreach ($education as $id => $value)
                <option
                    @selected($id == old('education', $data['education'] ?? -1)) value="{{ $id }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="experience">Опыт работы:</label>
        <select name="experience" id="experience" class="form-select my-1">
            <option value="">Любой</option>
            @foreach ($experience as $id => $value)
                <option
                    @selected($id == old('experience', $data['experience'] ?? -1)) value="{{ $id }}">{{ $value }}</option>
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
        <label for="skills">Навыки:</label>
        <select name="skills[]" id="skills" class="form-select" multiple aria-label="Skills">
            <option value="">Любые</option>
            @foreach ($skills as $skill)
                <option @selected(in_array($skill['id'], old('skills', $data['skills'] ?? []))) value="{{ $skill['id'] }}">{{ $skill['name'] }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success mt-2">Найти</button>
    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-2">Сбросить</a>
</form>
