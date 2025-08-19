<?php

require_once 'config/Controller.php';

class UserController extends Controller {

    public function showRegister() {
        $this->render('register', [
            'title' => "Formule d'inscription",
        ]);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $passwordRaw = $_POST['password'] ?? '';
            $p = strlen($passwordRaw);
            
            
            if (!$username || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($passwordRaw) < 6) {
                var_dump($p);
                header('Location: /register?mdp=');
                exit;
            }

            $passwordHash = password_hash($passwordRaw, PASSWORD_BCRYPT);

            $stmt = $this->pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $passwordHash]);

            header('Location: /login');
            exit;
        }
    }

    public function showLogin() {
        $this->render('login', [
            'title' => 'Se connecter',
        ]);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || !$this->requireAuth()) {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: /login');
                exit;
            }

            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // régénérer l'ID de session pour empêcher fixation
                session_regenerate_id(true);
                // ne stocke que ce qui est nécessaire
                $_SESSION['user'] = [   
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                ];
                header('Location: /dashboard');
                exit;
            } else {
                header('Location: /login');
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
    }

}
