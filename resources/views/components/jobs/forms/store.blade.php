<form action="{{ route('employers.jobs.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">Название: @include('components.forms.is-required-mark')</label>
                <input type="text" name="title" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('title')]) id="title" placeholder="Введите название" required
                       value="{{ old('title') }}">
                @include('components.forms.error', ['errorKey' => 'title'])
            </div>

            <div class="form-group">
                <label for="salary_from">Зарплата (От):</label>
                <input type="number" name="salary_from" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('salary_from')]) id="salary_from"
                       placeholder="Минимальная зарплата" value="{{ old('salary_from') }}">
                @include('components.forms.error', ['errorKey' => 'salary_from'])
            </div>

            <div class="form-group">
                <label for="salary_to">Зарплата (До):</label>
                <input type="number" name="salary_to" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('salary_to')]) id="salary_to"
                       placeholder="Максимальная зарплата" value="{{ old('salary_to') }}">
                @include('components.forms.error', ['errorKey' => 'salary_to'])
            </div>

            <div class="form-group form-check">
                <label for="salary_employer_paid_taxes">Зарплата нетто</label>
                <input type="checkbox" name="salary_employer_paid_taxes" @class(['form-check-input', 'my-1', 'is-invalid' => $errors->has('salary_employer_paid_taxes')]) id="salary_employer_paid_taxes"
                      value="{{ old('salary_employer_paid_taxes') }}">
                @include('components.forms.error', ['errorKey' => 'salary_employer_paid_taxes'])
            </div>

            <div class="form-group">
                <label for="city_id">Город: @include('components.forms.is-required-mark')</label>
                <select name="city_id" id="city_id" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('city_id')]) required>
                    @foreach($cities as $city)
                        <option @selected(old('city_id') == $city['id'])
                                value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                    @endforeach
                </select>
                @include('components.forms.error', ['errorKey' => 'city_id'])
            </div>

            <div class="form-group mt-1">
                <label for="street">Улица: @include('components.forms.is-required-mark')</label>
                <input type="text" name="street" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('street')]) id="street" required
                       placeholder="Улица" value="{{ old('street') }}">
                @include('components.forms.error', ['errorKey' => 'street'])

            </div>

            <div class="form-group">
                <label for="experience">Опыт: @include('components.forms.is-required-mark')</label>
                <select name="experience" id="experience" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('experience')]) required>
                    @foreach($experience as $value => $text)
                        <option @selected(old('experience') == $value)
                                value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                </select>
                @include('components.forms.error', ['errorKey' => 'experience'])

            </div>

            <div class="form-group">
                <label for="education">Образование: @include('components.forms.is-required-mark')</label>
                <select name="education" id="education" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('education')]) required>
                    @foreach($education as $value => $text)
                        <option @selected(old('education') == $value)
                                value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                </select>
                @include('components.forms.error', ['errorKey' => 'education'])

            </div>

            <div class="form-group">
                <label for="schedule">Тип занятости: @include('components.forms.is-required-mark')</label>
                <select name="schedule" id="schedule" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('schedule')]) required>
                    @foreach($schedule as $value => $text)
                        <option @selected(old('schedule') == $value)
                                value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                </select>
                @include('components.forms.error', ['errorKey' => 'schedule'])

            </div>

            <div class="form-group">
                <label for="employment">График работы: @include('components.forms.is-required-mark')</label>
                <select name="employment" id="employment" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('employment')]) required>
                    @foreach($employment as $value => $text)
                        <option @selected(old('employment') == $value)
                                value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                </select>
                @include('components.forms.error', ['errorKey' => 'employment'])

            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="description">Описание: @include('components.forms.is-required-mark')</label>
                <textarea name="description" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('description')]) id="description" rows="10" required
                          placeholder="Введите описание">{{ old('description') }}</textarea>
                @include('components.forms.error', ['errorKey' => 'description'])

            </div>

            <div class="form-group">
                <label for="skills">Навыки: @include('components.forms.is-required-mark')</label>
                <select name="skills[]" id="skills" @class(['form-control', 'my-1', 'is-invalid' => $errors->has('skills')]) multiple aria-label="skills" required>
                    @foreach ($skills as $skill)
                        <option @selected(in_array($skill['id'], old('skills', [])))
                                value="{{ $skill['id'] }}">{{ $skill['name'] }}</option>
                    @endforeach
                </select>
                @include('components.forms.error', ['errorKey' => 'skills'])

                <button type="submit" class="btn btn-primary mt-1">Опубликовать</button>
            </div>
        </div>
    </div>
</form>
