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
            $_SESSION['errors'] = [];

            // Validation du nom
            if (!$username) {
                $_SESSION['errors']['username'] = "Veuillez entrer votre nom.";
            } elseif (strlen($username) < 3) {
                $_SESSION['errors']['username'] = "Le nom doit contenir au moins 3 caractères.";
            }

            // Validation de l'email
            if (!$email) {
                $_SESSION['errors']['email'] = "Veuillez entrer votre email.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['errors']['email'] = "Email invalide.";
            }

            // Validation du mot de passe
            if (!$passwordRaw) {
                $_SESSION['errors']['password'] = "Veuillez entrer un mot de passe.";
            } elseif (strlen($passwordRaw) < 6) {
                $_SESSION['errors']['password'] = "Le mot de passe doit contenir au moins 6 caractères.";
            }

            // Si erreurs de saisie, retour au formulaire
            if (!empty($_SESSION['errors'])) {
                header('Location: /register');
                exit;
            }

            // Vérifie unicité du nom
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $_SESSION['errors']['username'] = "Ce nom est déjà utilisé.";
                header('Location: /register');
                exit;
            }

            // Vérifie unicité de l'email
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['errors']['email'] = "Cet email est déjà utilisé.";
                header('Location: /register');
                exit;
            }

            $passwordHash = password_hash($passwordRaw, PASSWORD_BCRYPT);

            $stmt = $this->pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $passwordHash]);

            $_SESSION['success'] = "Inscription réussie, vous pouvez vous connecter.";
            unset($_SESSION['errors']);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $_SESSION['errors'] = [];

            // Vérification email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['errors']['email'] = "Email invalide.";
            }

            // Vérification mot de passe (vide)
            if (!$password) {
                $_SESSION['errors']['password'] = "Veuillez entrer votre mot de passe.";
            }

            // Si erreurs de saisie, retour au formulaire
            if (!empty($_SESSION['errors'])) {
                header('Location: /login');
                exit;
            }

            // Vérification en base
            $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if (!$user) {
                $_SESSION['errors']['email'] = "Aucun compte trouvé avec cet email.";
                header('Location: /login');
                exit;
            }

            if (!password_verify($password, $user['password'])) {
                $_SESSION['errors']['password'] = "Mot de passe incorrect.";
                header('Location: /login');
                exit;
            }

            // Connexion réussie
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
            ];
            unset($_SESSION['errors']);
            header('Location: /dashboard');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
    }

}
