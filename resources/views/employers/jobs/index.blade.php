@extends('layout.app')

@section('content')
    <h3 class="my-3">Доступные вакансии</h3>
    <div class="row">
        @foreach($jobs as $job)
            @include('components.jobs.card', ['job' => $job->toArray()])
        @endforeach
    </div>

    {{ $jobs->links() }}
@endsection
