<div class="card w-100 mt-4">
    <div class="card-body">
        <h5 class="card-title">{{ $employer['name'] }}</h5>
        <p class="card-text">Сектор: {{ isset($employer['sector']['parent']) ? $employer['sector']['parent']['name'] . ' - ' . $employer['sector']['name'] : $employer['sector']['name'] }}</p>
        <small class="d-block mb-2">Кол-во вакансий: {{ $employer['jobs_count'] }}</small>

{{--        <a href="{{ route('employers.show', ['employer' => $employer['id']]) }}" class="btn btn-primary">О Компании</a>--}}
        <a href="#" class="btn btn-primary">О Компании</a>

        @if($employer['jobs_count'] > 0)
{{--            <a href="{{ route('employers.jobs.index', ['employer' => $employer['id']]) }}" class="btn btn-primary">Вакансии</a>--}}
            <a href="#" class="btn btn-primary">Вакансии</a>
        @endif
    </div>
</div>
