<div class="col-md-12">
    <div class="card mb-3">
        <div class="card-header">{{ $apply['type'] == 0 ? 'Приглашение' : 'Отклик' }}</div>
        <div class="card-body">
            <p class="card-text">Вакансия: {{ $apply['employer_job_title'] }}</p>
            <p class="card-text">{{ sprintf('Отправлено: %s', $apply['created_at']->format('Y-m-d H:i:s')) }}</p>
            <p class="card-text">Статус: <span class="fw-bold">{{ $apply['status'] }}</span></p>
        </div>
        <div class="card-footer">
            <a href="{{ route('employers.jobs.invites-and-applies.show', ['apply' => $apply->getKey()]) }}" class="btn btn-primary">Детали</a>
            <a href="{{ route('employers.jobs.show', ['employer' => $apply->getAttribute('employer_id'), 'job' => $apply->getAttribute('employer_job_id')]) }}" class="btn btn-secondary">Вакансия</a>
            <a href="{{ route('resumes.show', ['resume' => $apply->getRelation('resume')->getKey()]) }}" class="btn btn-secondary">Резюме</a>
        </div>
    </div>
</div>
