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

    public function update()
    {
        $data = new SpreadersBox;
        $data = $data->getSpreader($_GET);

        $path = 'views/items/spreaders/update.html';
        include('views/template/main.tpl.html');
    }

    public function files()
    {
        /*try {
            $file = new Files;
            $file = $file->getSpreaderFile($_GET);
        } catch (Exception $e) {
            $file = array();
            $file['path'] = null;
        }*/
        //$file['path']
        //$data['id']

        $data['id'] = $_GET['id'];

        $path = 'views/items/spreaders/files.html';
        include('views/template/main.tpl.html');
    }

    public function actionAdd()
    {
        if ((new SpreadersBox)->addIt($_POST)) {
            header("Location: /spreaders/index");
        }
    }

    public function actionDelete()
    {
        if ((new SpreadersBox)->deleteIt($_GET)) {
            header("Location: /spreaders/index");
        }
    }

    public function actionUpdate()
    {
        if ((new SpreadersBox)->updateIt($_POST)) {
            header("Location: /spreaders/index");
        }
    }

    public function actionAddFile()
    {
        $id = $_POST['id'];

        //$data = $_POST['id'];

        //$data['path'] =
        //add file
        $file = new Files;
        $fileData = $file->insertFile();



        if ($file->addSpreaderFile($fileData)) {
            header("Location: /spreaders/files?id=$id");
        }
    }

    public function spreaders()
    {
        $path = 'views/items/users/hr/spreaders.html';
        include('views/template/main.tpl.html');
    }
}
