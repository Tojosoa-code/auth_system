<?php

    /**
     * Classe Router
     * Permet de définir et de dispatcher les routes HTTP de l'application.
     */
    class Router {

        // Tableau des routes enregistrées
        private $routes = [];

        /**
         * Enregistre une route GET
         * @param string $path
         * @param callable $callback
         */
        public function get($path, $callback) {
            $this->addRoute("GET", $path, $callback);
        }

        /**
         * Enregistre une route POST
         * @param string $path
         * @param callable $callback
         */
        public function post($path, $callback) {
            $this->addRoute("POST", $path, $callback);
        }

        /**
         * Enregistre une route PUT
         * @param string $path
         * @param callable $callback
         */
        public function put($path, $callback) {
            $this->addRoute("PUT", $path, $callback);
        }

        /**
         * Enregistre une route DELETE
         * @param string $path
         * @param callable $callback
         */
        public function delete($path, $callback) {
            $this->addRoute('DELETE', $path, $callback);
        }

        /**
         * Ajoute une route au tableau des routes
         * Transforme les paramètres dynamiques (ex: :id) en regex nommés
         * @param string $method
         * @param string $path
         * @param callable $callback
         */
        public function addRoute($method, $path, $callback) {
            $path = rtrim($path, "/");

            // Remplace les paramètres dynamiques par des groupes nommés regex
            $regex = preg_replace_callback('/:\w+/', function($matches)  {
                $name = substr($matches[0], 1);
                return '(?<' . $name . '>[^/]+)';
            }, $path);
            $regex = "#^" . $regex . "$#";

            $this->routes[] = [
                'method' => $method,
                'pattern' => $regex,
                'callback' => $callback
            ];
        }

        /**
         * Cherche une route correspondant à la requête et exécute son callback
         * Gère la surcharge de méthode HTTP via le champ _method
         */
        public function dispatch() {
            $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
            $uri = rtrim($uri, '/');
            $method = $_SERVER['REQUEST_METHOD'];

            // Permet la surcharge de méthode HTTP via un champ POST _method
            if($method === 'POST' && isset($_POST['_method'])) {
                $override = strtoupper($_POST["_method"]);
                if(in_array($override, ['PUT', 'DELETE'])) {
                    $method = $override;
                }
            }

            // Parcourt toutes les routes pour trouver une correspondance
            foreach($this->routes as $route) {
                if($method === $route['method'] && preg_match($route['pattern'], $uri, $matches)) {
                    $params = [];
                    // Récupère les paramètres nommés de l'URL
                    foreach($matches as $key => $value) {
                        if(!is_int($key)) {
                            $params[$key] = htmlspecialchars($value);
                        }
                    }

                    // Exécute le callback associé à la route
                    return call_user_func($route['callback'], $params);
                }
            }

            // Si aucune route ne correspond, retourne une erreur 404
            http_response_code(404);
            echo "404 - Page non trouvée";
        }

    }