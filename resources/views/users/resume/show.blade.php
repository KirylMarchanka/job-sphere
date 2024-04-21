@php use Carbon\Carbon; @endphp
@extends('layout.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="{{ route('users.resumes.update', $resume->getAttribute('id')) }}" method="POST">
                @csrf
                @method('PUT')
                <h1 class="display-4 mb-4">Обновить резюме: {{ $resume->getAttribute('title') }}</h1>

                <div class="row">
                    <div class="col-sm-12">
                        <p class="lead">Заголовок: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="title"
                               value="{{ $resume->getAttribute('title') }}"
                               @class(['form-control']) required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <p class="lead">Фамилия: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="personal_information[surname]"
                               value="{{ $resume->getRelation('personalInformation')->getAttribute('surname') }}"
                               @class(['form-control']) required>
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Имя: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="personal_information[name]"
                               value="{{ $resume->personalInformation->name }}" @class(['form-control']) required>
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Отчество:</p>
                        <input type="text" minlength="2" name="personal_information[middle_name]"
                               value="{{ $resume->personalInformation->middle_name }}" @class(['form-control'])>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <p class="lead">Статус: @include('components.forms.is-required-mark')</p>
                        <select name="status" @class(['form-control']) required>
                            @foreach($statuses as $status => $text)
                                <option
                                    value="{{ $status }}" @selected(old('status', $resume->getRawOriginal('status')) == $status)>{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <p class="lead">Дата рождения: @include('components.forms.is-required-mark')</p>
                        <input type="date" name="personal_information[birthdate]"
                               value="{{ old('personal_information[birthdate]', $resume->personalInformation->birthdate) }}"
                               @class(['form-control']) required>
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Пол: @include('components.forms.is-required-mark')</p>
                        <select name="personal_information[sex]" @class(['form-control']) required>
                            <option value="m" @selected(old('personal_information[sex]', $resume->personalInformation->sex) === 'm')>Мужчина
                            </option>
                            <option value="f" @selected(old('personal_information[sex]', $resume->personalInformation->sex) === 'f')>Женщина
                            </option>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Город проживания: @include('components.forms.is-required-mark')</p>
                        <select name="personal_information[city_id]" id="city" @class(['form-control']) required>
                            @foreach($cities as $city)
                                <option value="{{ $city['id'] }}" @selected(old('personal_information[city_id]', $resume->personalInformation->city_id) == $city['id'])>{{ $city['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h1 class="display-5">Рабочая информация</h1>

                <div class="row">
                    <div class="col-sm-6">
                        <p class="lead">Зарплата:</p>
                        <input type="number" name="salary"
                               value="{{ old('salary', $resume->salary) }}" @class(['form-control'])>
                    </div>

                    <div class="col-sm-6">
                        <p class="lead">График работы: @include('components.forms.is-required-mark')</p>
                        <select name="employment" @class(['form-control']) required>
                            @foreach($employments as $value => $text)
                                <option
                                    value="{{ $value }}" @selected(old('employment', $resume->employment) == $value)>{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <p class="lead">Тип занятости: @include('components.forms.is-required-mark')</p>
                        <select name="schedule" @class(['form-control']) required>
                            @foreach($schedules as $value => $text)
                                <option
                                    value="{{ $value }}" @selected(old('schedule', $resume->schedule) == $value)>{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h1 class="display-5">Контактная информация</h1>

                <div class="row">
                    <div class="col-sm-3">
                        <p class="lead">Номер телефона:</p>
                        <input type="tel" name="contact[mobile_number]"
                               value="{{ old('contact[mobile_number]', $resume->contact->mobile_number) }}" @class(['form-control'])>
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Почта:</p>
                        <input type="tel" name="contact[email]"
                               value="{{ old('contact[email]', $resume->contact->email) }}" @class(['form-control'])>
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">LinkedIn:</p>
                        <input type="text" name="contact[other_sources][linkedin]"
                               value="{{ old('contact[other_sources][linkedin]', $resume->contact->getAttribute('original_other_sources')['linkedin']) }}" @class(['form-control'])>
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Telegram:</p>
                        <input type="text" name="contact[other_sources][telegram]"
                               value="{{ old('contact[other_sources][telegram]', $resume->contact->getAttribute('original_other_sources')['telegram']) }}" @class(['form-control'])>
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Предпочитаемый способ связи:</p>
                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-mobile"
                                   value="0" @checked($resume->contact->getRawOriginal('preferred_contact_source') == 0)>
                            <label @class(["form-check-label"]) for="preferredContactSource">Номер телефона</label>
                        </div>

                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-email"
                                   value="1" @checked($resume->contact->getRawOriginal('preferred_contact_source') == 1)>
                            <label @class(["form-check-label"]) for="preferredContactSource">Почта</label>
                        </div>

                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-linkedin"
                                   value="2" @checked($resume->contact->getRawOriginal('preferred_contact_source') == 2)>
                            <label @class(["form-check-label"]) for="preferredContactSource">LinkedIn</label>
                        </div>

                        <div @class(["form-check", "form-check-inline"])>
                            <input @class(["form-check-input"]) type="radio" name="contact[preferred_contact_source]"
                                   id="preferredContactSource-telegram"
                                   value="3" @checked($resume->contact->getRawOriginal('preferred_contact_source') == 3)>
                            <label @class(["form-check-label"]) for="preferredContactSource">Telegram</label>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <p class="lead">Комментарий:</p>
                        <textarea
                            name="contact[comment]" @class(['form-control'])>{{ $resume['contact']['comment'] }}</textarea>
                    </div>
                </div>

                <h1 class="display-5">Навыки и специализации</h1>

                <div class="row">
                    <div class="col-sm-6">
                        <p class="lead">Навыки: @include('components.forms.is-required-mark')</p>
                        <select multiple name="skills[]" id="skills" @class(['form-control']) required>
                            @foreach($skills as $skill)
                                <option
                                    value="{{ $skill['id'] }}" @selected(in_array($skill['id'], old('skills', $resume->skills->pluck('id')->toArray())))>{{ $skill['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <p class="lead">Специализации: @include('components.forms.is-required-mark')</p>
                        <select multiple name="specializations[]" id="specializations"
                                @class(['form-control']) required>
                            @foreach($specializations as $specialization)
                                <option
                                    value="{{ $specialization['id'] }}" @selected(in_array($specialization['id'], old('specializations', $resume->specializations->pluck('id')->toArray())))>{{ $specialization['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h1 class="display-5">Описание</h1>

                <div class="row">
                    <div class="col-12">
                        <textarea
                            name="description" @class(['form-control'])>{{ old('description', $resume['description']) }}</textarea>
                    </div>
                </div>

                <h1 class="display-5">Опыт работы</h1>

                @foreach($resume->workExperiences as $workExperience)
                    <div class="row border py-2 mb-3">
                        <div class="col-12">
                            <p><b>Компания:</b> {{ $workExperience['company_name'] }}</p>
                            <p><b>Должность:</b> {{ $workExperience['position'] }}</p>
                            <p><b>Даты
                                    работы:</b> {{ sprintf('%s%s', $workExperience['from']->format('Y-m'), $workExperience['to'] !== null ? ' - ' . $workExperience['to']->format('Y-m') : '') }}
                            </p>
                            <a class="btn btn-danger">Удалить</a>
                            <a class="btn btn-primary">Редактировать</a>
                        </div>
                    </div>
                @endforeach
                <a class="btn btn-primary mb-3" href="">Добавить опыт работы</a>

                <h1 class="display-5">Образование</h1>

                @foreach($resume->education as $education)
                    <div class="row border py-2 mb-3">
                        <div class="col-12">
                            <p><b>Учреждение:</b> {{ $education->educationalInstitution->name }}</p>
                            <p><b>Факультет:</b> {{ $education->department }}</p>
                            <p><b>Специальность:</b> {{ $education->specialization }}</p>
                            <p><b>Даты
                                    обучения:</b> {{ sprintf('%s - %s', $education->start_date->format('Y-m'), $education->end_date->format('Y-m')) }}
                            </p>
                            <a class="btn btn-danger">Удалить</a>
                            <a class="btn btn-primary">Редактировать</a>
                        </div>
                    </div>
                @endforeach

                <div class="d-flex align-baseline justify-content-between my-3">
                    <a class="btn btn-primary me-3" href="">Добавить образование</a>

                    <button type="submit" class="btn btn-primary">Обновить резюме</button>
                </div>

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
