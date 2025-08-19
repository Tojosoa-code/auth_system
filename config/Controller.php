<?php

require_once dirname(__DIR__) . '/Core/Engine.php';

/**
 * Classe Controller
 * Contrôleur de base pour l'application.
 * Gère la session, le rendu des vues et l'authentification.
 */
class Controller {

    // Instance PDO pour la connexion à la base de données
    protected $pdo;

    /**
     * Constructeur
     * Initialise la session et stocke la connexion PDO.
     * @param PDO $pdo
     */
    public function __construct($pdo) {
        // Démarrage centralisé de la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->pdo = $pdo;
    }

    /**
     * Affiche une vue avec les paramètres donnés.
     * @param string $view Chemin de la vue à afficher
     * @param array $params Paramètres à passer à la vue
     */
    public function render($view, $params = []) {
        // Extraction des paramètres pour un accès direct
        extract($params);
        $title = $title ?? "VahaCode"; // Titre par défaut
        $layout = $layout ?? dirname(__DIR__) . '/Layout/default'; // Layout par défaut
        $data = $data ?? null;

        // Appel du moteur de rendu
        echo Engine::render($view, [
            'title' => $title,
            'layout' => $layout,
            'data' => $data,
            ...$params
        ]);
    }

    /**
     * Vérifie si l'utilisateur est connecté.
     * Redirige vers /login si non authentifié.
     */
    protected function requireAuth() {
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}
