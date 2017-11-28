<?php

class UsersController
{
    public function index()
    {
        $path = 'views/items/users/admin/all.html';
        include('views/template/main.tpl.html');
    }

    public function spreaders()
    {
        $path = 'views/items/users/hr/spreaders.html';
        include('views/template/main.tpl.html');
    }
}
