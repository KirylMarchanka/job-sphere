@extends('layout.app')

@section('content')
    <div class="mt-5 p-3 border">
        <h2 class="mb-3">Войти как @yield('entity')</h2>

        <form method="POST" action=@yield('action')>
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Почта @include('components.forms.is-required-mark')</label>
                <input type="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) id="email" value="{{ old('email') }}" name="email" required>
                @include('components.forms.error', ['errorKey' => 'email'])
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль @include('components.forms.is-required-mark')</label>
                <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) id="password" name="password" required>
                @include('components.forms.error', ['errorKey' => 'password'])
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" @class(['form-check-input', 'is-invalid' => $errors->has('remember_me')]) name="remember_me" id="remember_me">
                <label class="form-check-label" for="remember_me">Запомнить</label>
            </div>

            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>

@endsection
