@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4 my-3">Отклики и приглашения</h1>
            <div class="row">
                @forelse($applies as $apply)
                    @include('components.jobs.invites.card', ['apply' => $apply])
                @empty
                    <p>Не найдено откликов и приглашений, соответствующих вашим критериям поиска.</p>
                @endforelse
            </div>
        </div>
    </div>

@endsection
