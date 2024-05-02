@php use Carbon\Carbon; @endphp
@extends('layout.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="{{ route('users.resumes.store') }}" id="resume-store" method="POST">
                @csrf
                <h1 class="display-4 mb-4">Создать резюме</h1>

                <div class="row">
                    <div class="col-sm-12">
                        <p class="lead">Заголовок: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="title" value="{{ old('title') }}" @class(['form-control']) required>
                        @include('components.forms.error', ['errorKey' => 'title'])
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <p class="lead">Фамилия: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="personal_information[surname]"
                               value="{{ old('personal_information[surname]') }}"
                               @class(['form-control']) required>
                        @include('components.forms.error', ['errorKey' => 'personal_information[surname]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Имя: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="personal_information[name]"
                               value="{{ old('personal_information[name]') }}" @class(['form-control']) required>
                        @include('components.forms.error', ['errorKey' => 'personal_information[name]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Отчество:</p>
                        <input type="text" minlength="2" name="personal_information[middle_name]"
                               value="{{ old('personal_information[middle_name]') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'personal_information[middle_name]'])
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <p class="lead">Статус: @include('components.forms.is-required-mark')</p>
                        <select name="status" @class(['form-control']) required>
                            @foreach($statuses as $status => $text)
                                <option
                                    value="{{ $status }}" @selected(old('status') == $status)>{{ $text }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'status'])
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <p class="lead">Дата рождения: @include('components.forms.is-required-mark')</p>
                        <input type="date" name="personal_information[birthdate]"
                               value="{{ old('personal_information[birthdate]') }}"
                               @class(['form-control']) required>
                        @include('components.forms.error', ['errorKey' => 'personal_information[birthdate]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Пол: @include('components.forms.is-required-mark')</p>
                        <select name="personal_information[sex]" @class(['form-control']) required>
                            <option
                                value="m" @selected(old('personal_information[sex]') === 'm')>
                                Мужчина
                            </option>
                            <option
                                value="f" @selected(old('personal_information[sex]') === 'f')>
                                Женщина
                            </option>
                        </select>
                        @include('components.forms.error', ['errorKey' => 'personal_information[sex]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Город проживания: @include('components.forms.is-required-mark')</p>
                        <select name="personal_information[city_id]" id="city" @class(['form-control']) required>
                            @foreach($cities as $city)
                                <option
                                    value="{{ $city['id'] }}" @selected(old('personal_information[city_id]') == $city['id'])>{{ $city['name'] }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'personal_information[city_id]'])
                    </div>
                </div>

                <h1 class="display-5">Рабочая информация</h1>

                <div class="row">
                    <div class="col-sm-6">
                        <p class="lead">Зарплата:</p>
                        <input type="number" name="salary"
                               value="{{ old('salary') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'personal_information[salary]'])
                    </div>

                    <div class="col-sm-6">
                        <p class="lead">График работы: @include('components.forms.is-required-mark')</p>
                        <select name="employment" @class(['form-control']) required>
                            @foreach($employments as $value => $text)
                                <option
                                    value="{{ $value }}" @selected(old('employment') == $value)>{{ $text }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'personal_information[employment]'])
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <p class="lead">Тип занятости: @include('components.forms.is-required-mark')</p>
                        <select name="schedule" @class(['form-control']) required>
                            @foreach($schedules as $value => $text)
                                <option
                                    value="{{ $value }}" @selected(old('schedule') == $value)>{{ $text }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'personal_information[schedule]'])
                    </div>
                </div>

                <h1 class="display-5">Контактная информация</h1>

                <div class="row">
                    <div class="col-sm-3">
                        <p class="lead">Номер телефона:</p>
                        <input type="tel" name="contact[mobile_number]"
                               value="{{ old('contact[mobile_number]') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'contact[mobile_number]'])
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Почта:</p>
                        <input type="email" name="contact[email]"
                               value="{{ old('contact[email]') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'contact[email]'])
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">LinkedIn:</p>
                        <input type="text" name="contact[other_sources][linkedin]"
                               value="{{ old('contact[other_sources][linkedin]') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'contact[other_sources][linkedin]'])
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Telegram:</p>
                        <input type="text" name="contact[other_sources][telegram]"
                               value="{{ old('contact[other_sources][telegram]') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'contact[other_sources][telegram]'])
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Предпочитаемый способ связи:</p>
                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-mobile"
                                   value="0" @checked(old('contact[preferred_contact_source]') == 0)>
                            <label @class(["form-check-label"]) for="preferredContactSource-mobile">Номер телефона</label>
                        </div>

                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-email"
                                   value="1" @checked(old('contact[preferred_contact_source]') == 1)>
                            <label @class(["form-check-label"]) for="preferredContactSource-email">Почта</label>
                        </div>

                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-linkedin"
                                   value="2" @checked(old('contact[preferred_contact_source]') == 2)>
                            <label @class(["form-check-label"]) for="preferredContactSource-linkedin">LinkedIn</label>
                        </div>

                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-telegram"
                                   value="3" @checked(old('contact[preferred_contact_source]') == 3)>
                            <label @class(["form-check-label"]) for="preferredContactSource-telegram">Telegram</label>
                        </div>

                        @include('components.forms.error', ['errorKey' => 'contact[preferred_contact_source]'])
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Комментарий:</p>
                        <textarea
                            name="contact[comment]" @class(['form-control'])>{{ old('contact[contact][comment]') }}</textarea>

                        @include('components.forms.error', ['errorKey' => 'contact[contact][comment]'])
                    </div>
                </div>

                <h1 class="display-5">Навыки и специализации</h1>

                <div class="row">
                    <div class="col-sm-6">
                        <p class="lead">Навыки: @include('components.forms.is-required-mark')</p>
                        <select multiple name="skills[]" id="skills" @class(['form-control']) required>
                            @foreach($skills as $skill)
                                <option
                                    value="{{ $skill['id'] }}" @selected(in_array($skill['id'], old('skills', [])))>{{ $skill['name'] }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'skills'])
                    </div>

                    <div class="col-sm-6">
                        <p class="lead">Специализации: @include('components.forms.is-required-mark')</p>
                        <select multiple name="specializations[]" id="specializations"
                                @class(['form-control']) required>
                            @foreach($specializations as $specialization)
                                <option
                                    value="{{ $specialization['id'] }}" @selected(in_array($specialization['id'], old('specializations', [])))>{{ $specialization['name'] }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'specializations'])
                    </div>
                </div>

                <h1 class="display-5">Описание</h1>

                <div class="row">
                    <div class="col-12">
                        <textarea
                            name="description" @class(['form-control'])>{{ old('description') }}</textarea>
                        @include('components.forms.error', ['errorKey' => 'description'])
                    </div>
                </div>

                <h1 class="display-5">Опыт работы</h1>
                <div class="border p-3">
                    <div class="row">
                        <div class="col-sm-4">
                            <p class="lead">Местоположение: @include('components.forms.is-required-mark')</p>
                            <select name="work_experiences[0][city_id]" id="city" @class(['form-control'])>
                                @foreach($cities as $city)
                                    <option
                                        value="{{ $city['id'] }}" @selected(old('work_experiences[0][city_id]') == $city['id'])>{{ $city['name'] }}</option>
                                @endforeach
                            </select>
                            @include('components.forms.error', ['errorKey' => 'work_experiences[0][city_id]'])
                        </div>

                        <div class="col-sm-4">
                            <p class="lead">Компания: @include('components.forms.is-required-mark')</p>
                            <input type="text" name="work_experiences[0][company_name]"
                                   value="{{ old('work_experiences[0][company_name]') }}" @class(['form-control'])>
                            @include('components.forms.error', ['errorKey' => 'work_experiences[0][company_name]'])
                        </div>

                        <div class="col-sm-4">
                            <p class="lead">Должность: @include('components.forms.is-required-mark')</p>
                            <input type="text" name="work_experiences[0][position]"
                                   value="{{ old('work_experiences[0][position]') }}" @class(['form-control'])>
                            @include('components.forms.error', ['errorKey' => 'work_experiences[0][position]'])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <p class="lead">Сайт компании:</p>
                            <input type="url" name="work_experiences[0][site_url]"
                                   value="{{ old('work_experiences[0][site_url]') }}" @class(['form-control'])>
                            @include('components.forms.error', ['errorKey' => 'work_experiences[0][site_url]'])
                        </div>

                        <div class="col-sm-8">
                            <p class="lead">Описание:</p>
                            <textarea name="work_experiences[0][description]" @class(['form-control'])>{{ old('work_experiences[0][description]') }}</textarea>
                            @include('components.forms.error', ['errorKey' => 'work_experiences[0][description]'])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <p class="lead">Начало работы: @include('components.forms.is-required-mark')</p>
                            <input type="date" name="work_experiences[0][from]"
                                   value="{{ old('work_experiences[0][from]') }}"
                                   @class(['form-control']) required>
                            @include('components.forms.error', ['errorKey' => 'work_experiences[0][from]'])
                        </div>

                        <div class="col-sm-4">
                            <p class="lead">Окончание работы:</p>
                            <input type="date" name="work_experiences[0][to]"
                                   value="{{ old('work_experiences[0][to]') }}"
                                @class(['form-control'])>
                            @include('components.forms.error', ['errorKey' => 'work_experiences[0][to]'])
                        </div>
                    </div>
                </div>

                <h1 class="display-5">Образование</h1>
                <div class="border p-3 mb-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="lead">Учреждение образования: @include('components.forms.is-required-mark')</p>
                            <select name="education[0][educational_institution_id]" @class(['form-control']) required>
                                @foreach($educationalInstitutions as $educationalInstitution)
                                    <option
                                        value="{{ $educationalInstitution->id }}" @selected(old('education[0][educational_institution_id]') == $educationalInstitution->id)>{{ $educationalInstitution->name }}</option>
                                @endforeach
                            </select>
                            @include('components.forms.error', ['errorKey' => 'education[0][educational_institution_id]'])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <p class="lead">Факультет: @include('components.forms.is-required-mark')</p>
                            <input type="text" name="education[0][department]"
                                   value="{{ old('education[0][department]') }}" @class(['form-control'])>
                            @include('components.forms.error', ['errorKey' => 'education[0][department]'])
                        </div>

                        <div class="col-sm-4">
                            <p class="lead">Специальность: @include('components.forms.is-required-mark')</p>
                            <input type="text" name="education[0][specialization]"
                                   value="{{ old('education[0][specialization]') }}" @class(['form-control'])>
                            @include('components.forms.error', ['errorKey' => 'education[0][specialization]'])
                        </div>

                        <div class="col-sm-4">
                            <p class="lead">Уровень образования: @include('components.forms.is-required-mark')</p>
                            <select name="education[0][degree]" @class(['form-control'])>
                                @foreach($degrees as $value => $text)
                                    <option
                                        value="{{ $value }}" @selected(old('education[0][degree]') == $value)>{{ $text }}</option>
                                @endforeach
                            </select>
                            @include('components.forms.error', ['errorKey' => 'education[0][degree]'])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <p class="lead">Начало обучения: @include('components.forms.is-required-mark')</p>
                            <input type="date" name="education[0][start_date]"
                                   value="{{ old('education[0][start_date]') }}"
                                   @class(['form-control']) required>
                            @include('components.forms.error', ['errorKey' => 'education[0][start_date]'])
                        </div>

                        <div class="col-sm-4">
                            <p class="lead">Окончание обучения: @include('components.forms.is-required-mark')</p>
                            <input type="date" name="education[0][end_date]"
                                   value="{{ old('education[0][end_date]"') }}"
                                   @class(['form-control']) required>
                            @include('components.forms.error', ['errorKey' => 'education[0][end_date]"'])
                        </div>
                    </div>
                </div>

                <button type="submit" form="resume-store" class="btn btn-primary mb-3">Создать</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#skills').select2({
                maximumSelectionLength: 10,
                placeholder: "Выберите до 10 навыков"
            });

            $('#specializations').select2({
                maximumSelectionLength: 10,
                placeholder: "Выберите до 10 специальностей"
            });

            $('#city').select2({
                placeholder: "Выберите город проживания"
            });
        });
    </script>
@endsection
