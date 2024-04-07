@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-3 mt-3">
            <h4 class="my-3">Поиск работодателей</h4>

            @include('components.employers.index-search', ['sectors' => $sectors, 'sector' => old('sector', $sector), 'name' => old('name', $name)])
        </div>

        <div class="col-md-9">
            <h1 class="display-4 my-3">Работодатели</h1>

            @forelse($employers as $employer)
                @include('components.employers.index-card', ['employer' => $employer])
            @empty
                <p>Не найдено работодателей, соответствующих вашим критериям поиска.</p>
            @endforelse
        </div>

        {{ $employers->links() }}

    </div>

@endsection
