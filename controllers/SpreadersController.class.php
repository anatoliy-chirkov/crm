<?php

class SpreadersController
{
    public function index()
    {
        $data = new SpreadersBox;
        $data = $data->getSpreadersList();

        $path = 'views/items/spreaders/all.html';
        include('views/template/main.tpl.html');
    }

    public function add()
    {
        $path = 'views/items/spreaders/add.html';
        include('views/template/main.tpl.html');
    }

    public function actionAdd()
    {
        if ((new SpreadersBox)->addIt($_POST)) {
            header("Location: /spreaders/index");
        }
    }

    public function spreaders()
    {
        $path = 'views/items/users/hr/spreaders.html';
        include('views/template/main.tpl.html');
    }
}
