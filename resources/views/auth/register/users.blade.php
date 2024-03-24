@extends('layout.app')

@section('content')
    <div class="mt-5 p-3 border">
        <h2 class="mb-3">Новый пользователь</h2>

        <form method="POST" action="{{ route('users.auth.register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">ФИО @include('components.forms.is-required-mark')</label>
                <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name" value="{{ old('name') }}" name="name" required>
                @include('components.forms.error', ['errorKey' => 'name'])
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Почта @include('components.forms.is-required-mark')</label>
                <input type="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) id="email" value="{{ old('email') }}" name="email" required>
                @include('components.forms.error', ['errorKey' => 'email'])
            </div>

            <div class="mb-3">
                <label for="mobile_number" class="form-label">Номер телефона</label>
                <input type="tel" @class(['form-control', 'is-invalid' => $errors->has('mobile_number')]) id="mobile_number" value="{{ old('mobile_number') }}" name="mobile_number">
                @include('components.forms.error', ['errorKey' => 'mobile_number'])
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль @include('components.forms.is-required-mark')</label>
                <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) id="password" name="password" required>
                @include('components.forms.error', ['errorKey' => 'password'])
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтверждение пароля @include('components.forms.is-required-mark')</label>
                <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </div>

@endsection
