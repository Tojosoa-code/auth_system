<?php

    require_once 'config/Controller.php';

    class HomeController extends Controller {

        public function index() {
            $this->render("home");
        }

    }