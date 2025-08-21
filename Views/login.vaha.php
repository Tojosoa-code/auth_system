@extends('Layout/form')

@section('title')
    {{ $title }}
@endsection('title')

@section('right')
    <div class="right">
        <h1 class='text-center my-5'>Se connecter</h1>
        <form action="/login" method="post">
            <div class="mb-3">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" required placeholder="Ex: JohnDoe@gmail.com">
                <?php if (!empty($_SESSION['errors']['email'])): ?>
                    <div class="text-danger mt-1"><?= $_SESSION['errors']['email'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 password-field">
                <label for="password">Mot de passe</label>
                <input class="form-control" type="password" name="password" id="password" required>
                <?php if (!empty($_SESSION['errors']['password'])): ?>
                    <div class="text-danger mt-1"><?= $_SESSION['errors']['password'] ?></div>
                <?php endif; ?>
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            <div class="bottom">
                <button type="submit" class="btn btn-primary">Se connecter <i class="fa fa-right-to-bracket"></i></button>
                <a href="/register">Vous n'avez pas de compte ?</a>
            </div>
        </form>
        <?php unset($_SESSION['errors']); ?>
    </div>
@endsection('right')

@section('left')
    <div class="left degrade">
        <div class="all">
            <div class="icon">
                <i class='fas fa-user'></i>
            </div>
            <div class="paragraphe">
                <h2>Accès rapide</h2>
                <p>Connectez-vous pour accéder à votre espace personnel et gérer vos données.</p>
            </div>
        </div>
        <div class="all">
            <div class="icon">
                <i class='fas fa-face-grin-wink'></i>
            </div>
            <div class="paragraphe">
                <h2>Sécurité garantie</h2>
                <p>Vos informations sont protégées grâce u chiffrement et aux bonnes pratiques.</p>
            </div>
        </div>
    </div>
@endsection('left')

@section('script')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', (e) => {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            e.currentTarget.classList.toggle('fa-eye');
            e.currentTarget.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection('script')