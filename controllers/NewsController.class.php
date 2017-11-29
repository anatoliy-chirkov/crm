<?php

class NewsController
{
    public function index()
    {
        $path = 'views/items/news/admin/index.html';
        include('views/template/main.tpl.html');
    }

    public function add()
    {
        $path = 'views/items/news/admin/add.html';
        include('views/template/main.tpl.html');
    }

    public function actionAdd()
    {
        $path = 'views/items/news/admin/index.html';
        include('views/template/main.tpl.html');
    }
}
