<li class="nav-item">
    <a class="nav-link" href="{{ route('employers.jobs.index') }}">Мои вакансии</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('employers.jobs.create') }}">Новая вакансия</a>
</li>
<li class="nav-item">
    <form method="POST" action="{{ route('employers.auth.logout') }}">
        @csrf
        <button class="btn btn-sm nav-link fs-6" type="submit">Выйти</button>
    </form>
</li>
