<?php

    require_once 'config/Controller.php';

    class DashboardController extends Controller {

        /**
         * Affiche le tableau de bord
         */
        public function dashboard() {
            $this->render("dashboard/index");
        }

        /**
         * Permet de changer le mot de passe de l'utilisateur connecté
         */
        public function change() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupère les infos de l'utilisateur connecté
                extract($_SESSION['user']);
                $ancien = $_POST['ancienPassword'] ?? '';
                $new = $_POST['newPassword'] ?? '';

                // Récupère l'utilisateur en base
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
                $stmt->execute([$id]);
                $mdp = $stmt->fetch();

                // Vérifie l'ancien mot de passe
                if (!$mdp || !password_verify($ancien, $mdp['password'])) {
                    $_SESSION['error'] = "L'ancien mot de passe est incorrect.";
                    header("Location: /dashboard");
                    exit;
                }

                // Vérifie la longueur du nouveau mot de passe
                if (strlen($new) < 6) {
                    $_SESSION['error'] = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
                    header('Location: /dashboard');
                    exit;
                }

                // Hash le nouveau mot de passe
                $hashed = password_hash($new, PASSWORD_DEFAULT);

                // Met à jour le mot de passe en base
                $st = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $st->execute([$hashed, $id]);

                $_SESSION['success'] = "Mot de passe changé avec succès.";
                header("Location: /dashboard");
                exit;
            }
        }

        /**
         * Permet de modifier le nom et l'email de l'utilisateur connecté
         */
        public function updateInfo() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_SESSION['user']['id'];
                $username = trim($_POST['username'] ?? '');
                $email = trim($_POST['email'] ?? '');

                // Validation des champs
                if (!$username || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['info_error'] = "Nom ou email invalide.";
                    header("Location: /dashboard");
                    exit;
                }

                // Vérifie unicité du nom
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
                $stmt->execute([$username, $id]);
                if ($stmt->fetch()) {
                    $_SESSION['info_error'] = "Ce nom est déjà utilisé.";
                    header("Location: /dashboard");
                    exit;
                }

                // Vérifie unicité de l'email
                $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $stmt->execute([$email, $id]);
                if ($stmt->fetch()) {
                    $_SESSION['info_error'] = "Cet email est déjà utilisé.";
                    header("Location: /dashboard");
                    exit;
                }

                // Met à jour les informations
                $stmt = $this->pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
                $stmt->execute([$username, $email, $id]);
                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['email'] = $email;
                $_SESSION['info_success'] = "Informations modifiées avec succès.";
                header("Location: /dashboard");
                exit;
            }
        }

    }