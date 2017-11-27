<?php

class AuthController
{
    public function auth()
    {
        session_start();

        $auth = new Auth;

        if ($_POST['logout']) {
            $auth->logout();
            $this->getStartView();
        } else if ($_POST['auth']) {
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

    public function getStartView()
    {
        $checker = new AuthChecker();

        if ($checker->isMaster()) {

            $menu = 'views/menu/master/index.php';
            $path = 'views/items/orders/index.php';
            include('views/template/template2.php');

        } else if ($checker->isOperator()) {

            $menu = 'views/menu/operator/index.php';
            $path = 'views/items/orders/index.php';
            include('views/template/template2.php');

        } else if ($checker->isHr()) {

            $path = 'views/items/users/index.php';
            include('views/template/template2.php');

        } else if ($checker->isAdmin()) {

            $menu = 'views/menu/admin/index.php';
            $path = 'views/items/orders/index.php';
            include('views/template/template2.php');

        } else {

            $path = 'views/items/auth/index.php';
            include('views/template/index.php');

        }
    }
}
