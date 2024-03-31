@extends('layout.app')

@section('content')
    <h1 class="display-4 my-3">Доступные вакансии</h1>
    <div class="row">
        @foreach($jobs as $job)
            @include('components.jobs.card', ['job' => $job->toArray()])
        @endforeach
    </div>

    {{ $jobs->links() }}
@endsection
