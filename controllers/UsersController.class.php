<?php

class UsersController
{
    public function index()
    {
        $data = new UserBox;
        $data = $data->getUserList();

        $path = 'views/items/users/admin/all.html';
        include('views/template/main.tpl.html');
    }

    public function add()
    {
        $path = 'views/items/users/admin/add.html';
        include('views/template/main.tpl.html');
    }

    public function profile()
    {
        $data = new UserBox;
        $data = $data->getProfile();

        $path = 'views/items/users/admin/profile.html';
        include('views/template/main.tpl.html');
    }

    public function actionAdd()
    {
        if ((new Auth)->signUp($_POST)) {
            header("Location: /users/index");
        }
    }

    public function spreaders()
    {
        $path = 'views/items/users/hr/spreaders.html';
        include('views/template/main.tpl.html');
    }
}
