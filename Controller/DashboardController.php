<?php

    require_once 'config/Controller.php';

    class DashboardController extends Controller {

        public function dashboard() {
            $this->render("dashboard/index");
        }

    }