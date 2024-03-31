<div class="col-md-12 mb-3">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $employer['name'] }}</h5>
            <p class="card-text text-truncate">{{ $employer['description'] }}</p>
            <p class="card-text">Открытых вакансий: {{ $employer['jobs_count'] }}</p>
            <a href="{{ route('employers.show', ['employer' => $employer['id']]) }}" class="btn btn-primary">О Компании</a>
        </div>
    </div>
</div>
