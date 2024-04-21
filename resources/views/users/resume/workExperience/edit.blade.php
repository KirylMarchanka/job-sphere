@extends('layout.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md-12">
            <form action="{{ route('users.resumes.work-experiences.update', ['resume' => $resume->getKey(), 'workExperience' => $workExperience->getKey()]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-4">
                        <p class="lead">Местоположение: @include('components.forms.is-required-mark')</p>
                        <select name="work_experiences[0][city_id]" id="city" @class(['form-control']) required>
                            @foreach($cities as $city)
                                <option
                                    value="{{ $city['id'] }}" @selected(old('work_experiences[0][city_id]', $workExperience->city_id) == $city['id'])>{{ $city['name'] }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'work_experiences[0][city_id]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Компания: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="work_experiences[0][company_name]" required
                               value="{{ old('work_experiences[0][company_name]', $workExperience->company_name) }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'work_experiences[0][company_name]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Должность: @include('components.forms.is-required-mark')</p>
                        <input type="text" name="work_experiences[0][position]" required
                               value="{{ old('work_experiences[0][position]', $workExperience->position) }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'work_experiences[0][position]'])
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <p class="lead">Сайт компании:</p>
                        <input type="url" name="work_experiences[0][site_url]"
                               value="{{ old('work_experiences[0][site_url]', $workExperience->site_url) }}" @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'work_experiences[0][site_url]'])
                    </div>

                    <div class="col-sm-8">
                        <p class="lead">Описание:</p>
                        <textarea name="work_experiences[0][description]" @class(['form-control'])>{{ old('work_experiences[0][description]', $workExperience->description) }}</textarea>
                        @include('components.forms.error', ['errorKey' => 'work_experiences[0][description]'])
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <p class="lead">Начало работы: @include('components.forms.is-required-mark')</p>
                        <input type="date" name="work_experiences[0][from]"
                               value="{{ old('work_experiences[0][from]', $workExperience->getAttribute('from')->format('Y-m-d')) }}"
                               @class(['form-control']) required>
                        @include('components.forms.error', ['errorKey' => 'work_experiences[0][from]'])
                    </div>

                    <div class="col-sm-4">
                        <p class="lead">Окончание работы:</p>
                        <input type="date" name="work_experiences[0][to]"
                               value="{{ old('work_experiences[0][to]', $workExperience->getAttribute('to')?->format('Y-m-d')) }}"
                               @class(['form-control'])>
                        @include('components.forms.error', ['errorKey' => 'work_experiences[0][to]'])
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Обновить</button>
            </form>
        </div>
    </div>
    @csrf
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#city').select2({
                placeholder: "Выберите местоположение работы"
            });
        });
    </script>
@endsection
