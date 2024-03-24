@guest
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="login-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="login-modal-label">Войти как</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" href="{{ route('users.auth.login-show') }}">Соискатель</a>
                    <a class="btn btn-primary" href="#">Работодатель</a>
                </div>
            </div>
        </div>
    </div>
@endguest
