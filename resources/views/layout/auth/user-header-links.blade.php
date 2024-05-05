<li class="nav-item">
    <a class="nav-link" href="{{ route('users.profile.show') }}">Профиль</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('users.resumes.index') }}">Резюме</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('users.invites-and-applies.index') }}">Отклики и приглашения</a>
</li>
<li class="nav-item">
    <form method="POST" action="{{ route('users.auth.logout') }}">
        @csrf
        <button class="btn btn-sm nav-link fs-6" type="submit">Выйти</button>
    </form>
</li>
