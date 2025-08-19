@extends('Layout/default')

@section('title')
   {{ $title }}
@endsection

@section('style')
    form {
        .password-ancien, .password-new {
            position: relative;
            i {
                position: absolute;
                top: 65%;
                right: 20px;
                font-size: .8rem;
                cursor: pointer;
            }
        }

        .bottom {
            margin-top: 50px;
        }

@endsection

@section('content')
<?php
    extract($_SESSION['user']);
    $error = false;
    $error2 = false;
    $success = false;

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ancien = $_POST['ancienPassword'];
        $new = $_POST['newPassword'];

        $bdd = Database::getConnexion();
        $stmt = $bdd->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $mdp = $stmt->fetch();

        if(!password_verify($ancien, $mdp['password'])) {
            $error = true;
            header("Location: /d");
            exit;
        }

        if(strlen($new) < 6) {
            $error2 = true;
            header('Location: /d');
            exit;
        }

        $st = $bdd->prepare('UPDATE users SET password = ? WHERE id = ?');
        $s->execute([$new, $id]);
        $success = true;
        header("Location: /d");
        exit;
    }
?>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary rounded" aria-label="Eleventh navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="/dashboard">Auth System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample09">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                    <div class="d-lg-flex col-lg-3 justify-content-lg-end">
                        <form action="/logout" method="get">
                            <button class="btn btn-primary">Deconnexion <i class="fas fa-sign-out-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>  

    <div class="content mt-5">

    @if($error) 
        <div>error</div>
    @else

    @endif

    @if($error2) 
        <div>error2</div>
    @endif

    @if($success) 
        <div>success</div>
    @endif

        <div class="col-md-15">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                <h2><i class='fas fa-user'></i>Utilisateur</h2>
                <p>Bonjour, Bienvenue sur Auth System <strong>{{ $username }}.</strong></p>
            </div>
        </div>
        <div class="information d-flex mt-3 gap-3 justify-content-between">
            <div class="col-md-15" style="width: 50%;">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <h2><i class='fas fa-info-circle'></i>Information</h2>
                    <p class="mt-3">Nom : <strong>{{ $username }}</strong></p>
                    <p>Email : <strong>{{ $email }}</strong></p>
                </div>
            </div>
            <div class="col-md-15" style="width: 50%;">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <h2><i class='fas fa-refresh'></i>Reinitialiser mot de passe</h2>
                    <form method="post">
                        <div class="mb-3 password-ancien">
                            <label class='form-label' for="ancienPassword">Ancien Mot de passe</label>
                            <input class='form-control' type="password" name="ancienPassword" id="ancienPassword" required>
                            <i class='fas fa-eye' id='togglePasswordAncien'></i>
                        </div>
                        <div class="mb-3 password-new">
                            <label class='form-label' for="newPassword">Nouveau Mot de passe</label>
                            <input class='form-control' type="password" name="newPassword" id="newPassword" required>
                            <i class='fas fa-eye' id='togglePasswordNew'></i>
                        </div>
                        <div class="bottom">
                            <button type="submit" class="btn btn-primary">Changer <i class="fa fa-refresh"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const togglePassword = document.querySelector('#togglePasswordAncien');
        const password = document.querySelector('#ancienPassword');

        togglePassword.addEventListener('click', (e) => {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            e.currentTarget.classList.toggle('fa-eye');
            e.currentTarget.classList.toggle('fa-eye-slash');
        });

        // password new

        const togglePasswordNew = document.querySelector('#togglePasswordNew');
        const passwordNew = document.querySelector('#newPassword');

        togglePasswordNew.addEventListener('click', (e) => {
            const type = passwordNew.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordNew.setAttribute('type', type); 
            e.currentTarget.classList.toggle('fa-eye');
            e.currentTarget.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection('script')

