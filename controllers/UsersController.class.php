<?php

class UsersController
{
    public function index()
    {
        $data = new UserBox;
        $data = $data->getUserList();

        Renderer::me()->setUsers($data)->setPath('users/all.html')->render();
    }

    public function add()
    {
        Renderer::me()->setPath('users/add.html')->render();
    }

    public function profile()
    {
        $data = new UserBox;
        $data = $data->getProfile();

        Renderer::me()->setUsers($data)->setPath('users/profile.html')->render();
    }

    public function actionAdd()
    {
        if ((new Auth)->signUp($_POST)) {
            header("Location: /users/index");
        }
    }
}
