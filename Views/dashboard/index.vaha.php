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
    }
@endsection

@section('content')
<?php
    extract($_SESSION['user']);
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
        <div class="col-md-15">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                <h2><i class='fas fa-user'></i>Utilisateur</h2>
                <p>Bonjour, Bienvenue sur Auth System <strong>{{ $username }}.</strong></p>
            </div>
        </div>
        <div class="information d-flex mt-3 gap-3 justify-content-between">
            <div class="col-md-15" style="width: 50%;">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">

                    <h2><i class='fas fa-info-circle'></i>Information <i class="fas fa-pen edit-info" style="cursor:pointer; font-size: .8rem;margin-left: 10rem;" title="Modifier" data-bs-toggle="modal" data-bs-target="#editInfoModal"></i></h2>
                    <?php if (isset($_SESSION['info_error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['info_error'] ?></div>
                        <?php unset($_SESSION['info_error']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['info_success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['info_success'] ?></div>
                        <?php unset($_SESSION['info_success']); ?>
                    <?php endif; ?>
                    <p class="mt-3">
                        Nom : <strong>{{ $username }}</strong>
                    </p>
                    <p>
                        Email : <strong>{{ $email }}</strong>
                    </p>
                </div>
            </div>
            <div class="col-md-15" style="width: 50%;">
                <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    <h2><i class='fas fa-refresh'></i>Reinitialiser mot de passe</h2>
                    <form action="/changer_mdp" method="post">
                        <div class="mb-3 password-ancien">
                            <label class='form-label' for="ancienPassword">Mot de passe actuelle</label>
                            <input class='form-control' type="password" name="ancienPassword" id="ancienPassword" required>
                            <i class='fas fa-eye' id='togglePasswordAncien'></i>
                        </div>
                        <div class="mb-3 password-new">
                            <label class='form-label' for="newPassword">Nouveau Mot de passe</label>
                            <input class='form-control' type="password" name="newPassword" id="newPassword" required>
                            <i class='fas fa-eye' id='togglePasswordNew'></i>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="bottom">
                            <button type="submit" class="btn btn-primary">Changer <i class="fa fa-refresh"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Bootstrap pour modifier nom et email -->
    <div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" action="/modifier_info" method="post">
          <input type="hidden" name="_method" value="PUT">
          <div class="modal-header">
            <h5 class="modal-title" id="editInfoModalLabel">Modifier mes informations</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="modalUsername" class="form-label">Nom</label>
              <input type="text" class="form-control" id="modalUsername" name="username" value="<?= htmlspecialchars($username) ?>" required>
            </div>
            <div class="mb-3">
              <label for="modalEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="modalEmail" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-success">Enregistrer</button>
          </div>
        </form>
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

