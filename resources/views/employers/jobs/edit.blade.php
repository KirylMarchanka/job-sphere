@extends('layout.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <h1 class="display-6">Обновление вакансии</h1>

    @include('components.jobs.forms.edit')
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#skills').select2({
                maximumSelectionLength: 10,
                placeholder: "Выберите до 10 навыков"
            });

            $('#city_id').select2({
                placeholder: "Выберите город"
            });
        });
    </script>
@endsection
