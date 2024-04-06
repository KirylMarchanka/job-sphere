@php use App\Components\Employer\Job\Enums\JobEducationEnum;use App\Components\Resume\Enums\EmploymentEnum; @endphp
@extends('layout.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 mt-3">
            @include('components.jobs.index-search', ['data' => $data, 'sectors' => $sectors, 'cities' => $cities, 'education' => $education, 'experience' => $experience, 'schedule' => $schedule, 'employment' => $employment, 'skills' => $skills])
        </div>

        <div class="col-md-9">
            <h1 class="display-4 my-3">Вакансии</h1>
            <div class="row">
                @forelse($jobs as $job)
                    @include('components.jobs.card', ['job' => $job->toArray()])
                @empty
                    <p>Не найдено вакансий, соответствующих вашим критериям поиска.</p>
                @endforelse
            </div>

            {{ $jobs->links() }}
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#skills').select2({
                maximumSelectionLength: 10,
                placeholder: "Выберите до 10 навыков"
            });
        });
    </script>
@endsection
