@extends('Layout/form')

@section('title')
    {{ $title }}
@endsection('title')

@section('left')
    <div class="left">        
        <h1 class='text-center my-5'>Formule d'inscription</h1>
        <form action="/register" method="POST">
            <div class="mb-3">
                <label class='form-label' for="username">Votre nom</label>
                <input class='form-control' type="text" name="username" id="username" required placeholder="Ex: John Doe">
            </div>
            <div class="mb-3">
                <label class='form-label' for="email">Votre Email</label>
                <input class='form-control' type="email" name="email" id="email" required placeholder="Ex: JohnDoe@gmail.com">
            </div>
            <div class="mb-3 password-field">
                <label class='form-label' for="password">Mot de passe</label>
                <input class='form-control' type="password" name="password" id="password" required>
                <i class='fas fa-eye' id='togglePassword'></i>
            </div>
            <div class="bottom">
                <button type="submit" class='btn btn-primary'>S'inscrire <i class="fa fa-user-plus"></i></button>
                <a href="/login">Vous avez déjà une compte ?</a>
            </div>
        </form>
    </div>
@endsection('left')

@section('right')
    <div class="right degrade">
        <div class="all">
            <div class="icon">
                <i class='fas fa-shield-alt'></i>
            </div>
            <div class="paragraphe">
                <h2>Sécurisé et rapide</h2>
                <p>Créer votre compte en toute sécurité et commencez à utiliser notre tableau de bord personnalisé.</p>
            </div>
        </div>
        <div class="all">
            <div class="icon">
                <i class='fas fa-bolt'></i>
            </div>
            <div class="paragraphe">
                <h2>Facile à utiliser</h2>
                <p>Une inscription simple pour accéder à toutes les fonctionnalités de l'application</p>
            </div>
        </div>
    </div>
@endsection('right')


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