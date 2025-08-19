<?php

    $router->get('/', [$home, 'index']);
    $router->get('/register', [$auth, 'showRegister']);
    $router->post('/register', [$auth, 'register']);
    $router->get('/login', [$auth, 'showLogin']);
    $router->get('/logout', [$auth, 'logout']); 
    $router->post('/login', [$auth, 'login']);

    $router->get('/dashboard', [$dash, 'dashboard']);

