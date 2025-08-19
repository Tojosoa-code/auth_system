<?php

    require 'config/Router.php';
    require 'config/Database.php';
    require 'Controller/UserController.php';
    require 'Controller/HomeController.php';
    require 'Controller/DashboardController.php';

    $router = new Router();
    $home = new HomeController(Database::getConnexion());
    $auth = new UserController(Database::getConnexion());
    $dash = new DashboardController(Database::getConnexion());
    
    // Mettre ici vos controlleur

    require 'Routes/Routes.php';

    $router->dispatch();