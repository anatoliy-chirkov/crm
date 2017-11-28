<?php

class NewsController
{
    public function index()
    {
        $path = 'views/items/news/admin/index.html';
        include('views/template/main.tpl.html');
    }
}
