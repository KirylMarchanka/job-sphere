@extends('layout.app')

@section('content')
    <div class="mt-5 p-3 border">
        <h2 class="mb-3">Новый работодатель</h2>

        <form method="POST" action="{{ route('employers.auth.register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Наименование @include('components.forms.is-required-mark')</label>
                <input type="text" @class(['form-control', 'is-invalid' => $errors->has('name')]) id="name" value="{{ old('name') }}" name="name" required>
                @include('components.forms.error', ['errorKey' => 'name'])
            </div>

            <div class="mb-3">
                <label for="sector_id" class="form-label">Сектор @include('components.forms.is-required-mark')</label>
                <select id="sector_id" name="sector_id" @class(['form-control', 'is-invalid' => $errors->has('email')]) id="sector_id" required>
                    @foreach($sectors as $sector)
                        <option @selected($sector['id'] == old('sector_id')) value="{{ $sector['id'] }}">{{ $sector['name'] }}</option>
                    @endforeach
                </select>
                @include('components.forms.error', ['errorKey' => 'sector_id'])
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание @include('components.forms.is-required-mark')</label>
                <tinymce-editor
                    required
                    name="description"
                    api-key="{{ config('services.tinymce.key') }}"
                    height="500"
                    menubar="false"
                    plugins="advlist autolink lists link image charmap preview anchor
        searchreplace visualblocks code fullscreen
        insertdatetime media table code help wordcount"
                    toolbar="undo redo | blocks | bold italic backcolor |
        alignleft aligncenter alignright alignjustify |
        bullist numlist outdent indent | removeformat | help"
                    content_style="body
      {
        font-family:Helvetica,Arial,sans-serif;
        font-size:14px
      }"
                >

                    <!-- Adding some initial editor content -->
                    {{ old('description') }}

                </tinymce-editor>
                @include('components.forms.error', ['errorKey' => 'description'])
            </div>

            <div class="mb-3">
                <label for="site_url" class="form-label">Сайт</label>
                <input type="url" @class(['form-control', 'is-invalid' => $errors->has('site_url')]) id="site_url" value="{{ old('site_url') }}" name="site_url">
                @include('components.forms.error', ['errorKey' => 'site_url'])
            </div>

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

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтверждение пароля @include('components.forms.is-required-mark')</label>
                <input type="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </form>
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@2/dist/tinymce-webcomponent.min.js"></script>
@endsection
