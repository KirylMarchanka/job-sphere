@extends('layout.app')

@section('content')
    <h3 class="my-3">Открытые вакансии</h3>
    <div class="row">
        @foreach($jobs as $job)
            @include('components.jobs.card', ['job' => $job])
        @endforeach
    </div>

    <h3 class="my-3">Работодатели</h3>
    <div class="row">
        @foreach($employers as $employer)
            @include('components.employers.card', ['employer' => $employer])
        @endforeach
    </div>
@endsection
