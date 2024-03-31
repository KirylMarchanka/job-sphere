@extends('layout.app')

@section('content')
    <div class="row mt-3">
        <div class="col-md-8">
            <h1 class="display-4 mb-4">Наниматель: {{ $employer['name'] }}</h1>
            <div class="row">
                <div class="col-sm-6">
                    <p class="lead">Сайт:</p>
                    <a href="{{ $employer['site_url'] ?? '#' }}">{{ $employer['site_url'] ?? '-' }}</a>
                </div>
                <div class="col-sm-6">
                    <p class="lead">Сектор:</p>
                    <p>{{ $employer['sector']['name'] }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="lead">Описание:</p>
                    <p>{{ $employer['description'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <h3 class="display-6 mb-3">Открытые вакансии</h3>
            @forelse($employer['jobs'] as $job)
                <div class="card-header">
                    <a href="{{ route('employers.jobs.show', ['employer' => $employer['id'], $job['id']]) }}">{{ $job['title'] }}</a>
                </div>
                <div class="card-body">
                    <p class="text-truncate">{{ $job['description'] }}</p>
                    <p class="fw-bold">{{ $job['salary'] }}</p>
                </div>
            @empty
                <div class="card-header">Нет вакансий</div>
                <div class="card-body">
                    <p>В настоящее время у этого работодателя нет вакансий.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
