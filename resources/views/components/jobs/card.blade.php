<div class="col-md-12">
    <div class="card mb-3">
        <div class="card-header">{{ $job['employer']['name'] }}</div>
        <div class="card-body">
            <h5 class="card-title">{{ $job['title'] }}</h5>
            <div class="card-text text-truncate">{!!  $job['description'] !!}</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Зарплата: <span class="fw-bold">{{ $job['salary'] }}</span></li>
                <li class="list-group-item">{{ $job['city']['city_with_country'] }}</li>
                <li class="list-group-item">{{ sprintf('%s, %s', $job['employment'], $job['schedule']) }}</li>
                @if(!empty($job['skills']))
                    <li class="list-group-item">
                        @foreach($job['skills'] as $skill)
                            @include('components.jobs.skill-badge', ['skill' => $skill['name']])
                        @endforeach
                    </li>
                @endif
                <li class="list-group-item">Требуемый опыт работы: {{ $job['experience'] }}</li>
            </ul>
        </div>
        <div class="card-footer">
            <a href="{{ route('employers.jobs.show', ['employer' => $job['employer']['id'], 'job' => $job['id']]) }}" class="btn btn-primary">Детали</a>
            <a href="{{ route('employers.show', ['employer' => $job['employer']['id']]) }}" class="btn btn-secondary">О Компании</a>
        </div>
    </div>
</div>
