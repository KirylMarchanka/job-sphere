@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Профиль пользователя</h1>
            <form action="{{ route('users.profile.update') }}" method="post" id="profile-update-form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Имя пользователя @include('components.forms.is-required-mark')</label>
                    <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name" name="name" value="{{ $user['name'] }}" required>
                    @include('components.forms.error', ['errorKey' => 'name'])
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) id="email" name="email" value="{{ $user['email'] }}">
                    @include('components.forms.error', ['errorKey' => 'email'])
                </div>
                <div class="mb-3">
                    <label for="mobile_number" class="form-label">Номер телефона</label>
                    <input type="tel" @class(['form-control', 'is-invalid' => $errors->has('mobile_number')]) id="mobile_number" name="mobile_number" value="{{ $user['mobile_number'] }}">
                    @include('components.forms.error', ['errorKey' => 'mobile_number'])
                </div>
                <div class="mb-3">
                    <label for="old_password" class="form-label">Текущий Пароль</label>
                    <input type="password" @class(['form-control', 'is-invalid' => $errors->has('old_password')]) id="old_password" name="old_password">
                    @include('components.forms.error', ['errorKey' => 'old_password'])
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Новый пароль</label>
                    <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) id="password" name="password">
                    @include('components.forms.error', ['errorKey' => 'password'])
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password_confirmation')]) id="password_confirmation" name="password_confirmation">
                    @include('components.forms.error', ['errorKey' => 'password_confirmation'])
                </div>
            </form>

            <form action="{{ route('users.profile.delete') }}" method="POST" id="profile-delete-form">
                @csrf
                @method('DELETE')
            </form>

            <button type="submit" form="profile-update-form" class="btn btn-primary">Сохранить</button>
            <button type="submit" form="profile-delete-form" class="btn btn-danger">Удалить</button>
        </div>
    </div>
@endsection
