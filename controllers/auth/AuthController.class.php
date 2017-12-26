<?php

class AuthController
{
    public function index()
    {
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

            (new OrdersController)->index();

        } else if ($checker->isOperator()) {

            (new CallsController)->index();

        } else if ($checker->isHr()) {

            (new SpreadersController)->index();

        } else if ($checker->isAdmin()) {

            (new OrdersController)->index();

        } else {

            Renderer::me()->render();

        }
    }
}
