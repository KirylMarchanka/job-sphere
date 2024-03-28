@guest
    <div class="modal fade" id="register-modal" tabindex="-1" aria-labelledby="register-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="register-modal-label">Зарегистрироваться как</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" href="{{ route('users.auth.register-show') }}">Соискатель</a>
                    <a class="btn btn-primary" href="{{ route('employers.auth.register-show') }}">Работодатель</a>
                </div>
            </div>
        </div>
    </div>
@endguest
