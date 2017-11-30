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
            $path = 'views/items/orders/master/index.html';
            include('views/template/main.tpl.html');

        } else if ($checker->isOperator()) {

            $menu = 'views/menu/operator/points.html';
            $path = 'views/items/orders/operator/index.html';
            include('views/template/main.tpl.html');

        } else if ($checker->isHr()) {

            $menu = 'views/menu/hr/points.html';
            $path = 'views/items/users/hr/index.html';
            include('views/template/main.tpl.html');

        } else if ($checker->isAdmin()) {

            (new OrdersController)->index();

        } else {

            $path = 'views/items/auth/index.html';
            include('views/template/auth.tpl.html');

        }
    }
}
