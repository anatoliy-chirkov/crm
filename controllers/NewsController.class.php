<?php

class NewsController
{
    public function index()
    {
        Renderer::me()->setPath('news/index.html')->render();
    }

    public function add()
    {
        Renderer::me()->setPath('news/add.html')->render();
    }

    public function actionAdd()
    {
        //to do
        Renderer::me()->setPath('news/index.html')->render();
    }
}
