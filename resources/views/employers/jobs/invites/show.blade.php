@extends('layout.app')

@section('style')
    <style>
        .message-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .message-footer {
            display: flex;
            justify-content: end;
            align-items: center;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .message-content p {
            line-height: 1.5;
        }

        .sender-name {
            color: #333;
        }

        .timestamp {
            color: #aaa;
            font-size: 0.8em;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="my-3">
                <div class="card-header">История переписки</div>
                @foreach($apply->getRelation('conversation')->getRelation('messages') as $message)
                    <div class="message-box">
                        <div class="message-header">
                            <span class="sender-name">{{ $message->getRelation('sender')->getAttribute('name') }}</span>
                            <span
                                class="timestamp">{{ $message->getAttribute('created_at')->format('Y-m-d H:i') }}</span>
                        </div>
                        <div class="message-content">
                            <p>{{ $message->getAttribute('message') }}</p>
                        </div>

                        @if($message->getAttribute('read_at') !== null)
                            <div class="message-footer">
                                <span
                                    class="timestamp">Прочтено: {{ $message->getAttribute('read_at')->format('Y-m-d H:i') }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($apply->getRawOriginal('status') === 0)
                <form id="chat-form" method="POST" action="{{ route('employers.jobs.invites-and-applies.update', ['apply' => $apply->getKey()]) }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="status">Статус</label>
                        <select name="status" id="status"
                                @class(['form-control', 'is-invalid' => $errors->has('status')]) required>
                            @foreach([1 => 'Отклонить', 2 => 'Пригласить на собеседование'] as $key => $status)
                                <option @selected(old('status') == $key)
                                        value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.error', ['errorKey' => 'status'])
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Сообщение</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required>{{ old('message') }}</textarea>
                        @include('components.forms.error', ['errorKey' => 'message'])
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('employers.jobs.invites-and-applies.index') }}" class="btn btn-secondary">Назад</a>

                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </form>
            @else
                <a href="{{ route('employers.jobs.invites-and-applies.index') }}" class="btn btn-secondary">Назад</a>
            @endif
        </div>
    </div>

@endsection
