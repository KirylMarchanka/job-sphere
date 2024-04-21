@extends('layout.app')

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="{{ route('users.resumes.educations.store', $resume->getAttribute('id')) }}" method="POST">
                @csrf
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
                        <input type="text" name="education[0][department]" required
                               value="{{ old('education[0][department]') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'education[0][department]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Специальность: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="education[0][specialization]" required
                               value="{{ old('education[0][specialization]') }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'education[0][specialization]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Уровень образования: @include('components.forms.is-required-mark')</p>
                        <select name="education[0][degree]" @class(['form-control']) required>
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

                <button type="submit" class="btn btn-primary">Сохранить</button>
            </form>
        </div>
    </div>
    @csrf
@endsection
