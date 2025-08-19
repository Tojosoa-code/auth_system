<?php

    /**
     * Classe Database
     * Gère la connexion à la base de données MySQL via PDO.
     */
    class Database {

        // Informations de connexion à la base de données
        private static $host = "127.0.0.1";
        private static $dbname = "auth_system";
        private static $username = "root";
        private static $password = "jotosoa007";

        /**
         * Retourne une instance PDO connectée à la base de données.
         * @return PDO
         */
        public static function getConnexion() {
            try {
                // Création de la connexion PDO
                $pdo = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                    self::$username,
                    self::$password
                );
                // Configuration des attributs PDO
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $pdo;
            } catch (PDOException $e) {
                // Amélioration : log l'erreur dans un fichier au lieu d'afficher à l'utilisateur
                error_log(date('[Y-m-d H:i:s] ') . "Erreur PDO : " . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/../logs/db_errors.log');
                // Affichage d'un message générique pour l'utilisateur
                die("
                    <!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Erreur SQL Base de donnée</title>
                        <link rel='stylesheet' href='/public/assets/css/bootstrap/bootstrap.min.css'>
                    </head>
                    <body class='container mt-5'>
                        <p class='alert alert-danger'>Erreur lors de la connexion à la base de donnée. Veuillez réessayer plus tard.</p>
                    </body>
                    </html>
                ");
            }
        }
    }