<?php

    $router->get('/', [$home, 'index']);
    $router->get('/register', [$auth, 'showRegister']);
    $router->post('/register', [$auth, 'register']);
    $router->get('/login', [$auth, 'showLogin']);
    $router->get('/logout', [$auth, 'logout']); 
    $router->post('/login', [$auth, 'login']);
    $router->put('/changer_mdp', [$dash, 'change']);
    $router->put('/modifier_info', [$dash, 'updateInfo']);
    $router->get('/dashboard', [$dash, 'dashboard']);

