@extends('Layout/default')

@section('title')
   {{ $title }}
@endsection

@section('content')
    <h1>Système d'authentification</h1>
    <div class="list">
        <form action="/register" method="get">
            <button class="btn btn-primary">S'inscrire <i class='fas fa-user-plus'></i></button>
        </form>
        <form action="/login" method="get">
            <button class="btn btn-secondary">Se connecter <i class='fas fa-sign-in-alt'></i></button>
        </form>
    </div>
    <div class="paragraphe">
        <div class="top d-flex gap-3 mb-3">
            <div class="col-md-6">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <h2><i class='fas fa-shield-alt'></i>Sécurisé et rapide</h2>
                    <p>Or, keep it light and add a border for some added definition to the boundaries of your content. </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <h2><i class='fas fa-face-grin-wink'></i>Sécurité garantie</h2>
                    <p>Or, keep it light and add a border for some added definition to the boundaries of your content. </p>
                </div>
            </div>
        </div>
        <div class="bottom d-flex gap-3">
            <div class="col-md-6">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <h2><i class='fas fa-user'></i>Accès rapide</h2>
                    <p>Or, keep it light and add a border for some added definition to the boundaries of your content. </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <h2><i class='fas fa-bolt'></i>Facile à utiliser</h2>
                    <p>Or, keep it light and add a border for some added definition to the boundaries of your content. </p>
                </div>
            </div>
        </div>
    </div>
@endsection

