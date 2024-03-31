@php use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\Session; @endphp

@include('components.auth.modals.login')
@include('components.auth.modals.register')

@if(Session::has('notification'))
    @include('components.notifications.notification', ['header' => Session::get('notification.header', 'Уведомление'), 'message' => Session::get('notification.message', '-')])
@endif

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-between">
        <a class="navbar-brand" href="/">Job Sphere</a>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jobs.index') }}">Вакансии</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('employers.index') }}">Компании</a>
            </li>
        </ul>

        <form class="d-flex mx-auto">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <ul class="navbar-nav mb-2 mb-lg-0">
            @auth('web.users')
                @include('layout.auth.user-header-links')
            @endauth

            @auth('web.employers')
                @include('layout.auth.employer-header-links')
            @endauth

            @if(!Auth::guard('web.users')->check() && !Auth::guard('web.employers')->check())
                <li class="nav-item">
                    <button class="btn btn-sm nav-link fs-6" type="submit" data-bs-toggle="modal"
                            data-bs-target="#login-modal">Войти
                    </button>
                </li>

                <li class="nav-item">
                    <button class="btn btn-sm nav-link fs-6" type="submit" data-bs-toggle="modal"
                            data-bs-target="#register-modal">Зарегистрироваться
                    </button>
                </li>
            @endif
        </ul>
    </div>
</nav>
