<?php

class AuthController
{
    public function index()
    {
        session_start();

        $auth = new Auth;

        if ($_POST['auth']) {
            $auth->signIn($_POST);
            $this->getStartView();
        } else if ($_SESSION['id']) {
            $this->getStartView();
        } else if ($auth->signInAuto()) {
            $this->getStartView();
        } else {
            $this->getStartView();
        }
    }

    public function logout()
    {
        $auth = new Auth;
        $auth->logout();
        header("Location: /");
    }

    public function getStartView()
    {
        $checker = new AuthChecker();

        if ($checker->isMaster()) {

            $menu = 'views/menu/master/points.html';
            $path = 'views/items/orders/index.php';
            include('views/template/main.tpl.html');

        } else if ($checker->isOperator()) {

            $menu = 'views/menu/operator/points.html';
            $path = 'views/items/orders/index.php';
            include('views/template/main.tpl.html');

        } else if ($checker->isHr()) {

            $path = 'views/items/users/index.php';
            include('views/template/main.tpl.html');

        } else if ($checker->isAdmin()) {

            $menu = 'views/menu/admin/points.html';
            $path = 'views/items/orders/index.php';
            include('views/template/main.tpl.html');

        } else {

            $path = 'views/items/auth/index.php';
            include('views/template/auth.tpl.html');

        }
    }
}
