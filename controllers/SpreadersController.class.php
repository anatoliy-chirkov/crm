<?php

class SpreadersController
{
    public function index()
    {
        $data = new SpreadersBox;
        $data = $data->getSpreadersList();

        Renderer::me()->setSpreaders($data)->setPath('spreaders/all.html')->render();
    }

    public function add()
    {
        Renderer::me()->setPath('spreaders/add.html')->render();
    }

    public function update()
    {
        $data = new SpreadersBox;
        $data = $data->getSpreader($_GET);

        Renderer::me()->setSpreaders($data)->setPath('spreaders/update.html')->render();
    }

    public function calls()
    {
        $data = new SpreadersBox;
        $calls = $data->getCallsBySpreader($_GET);
        $spreader = $data->getSpreader($_GET);

        Renderer::me()->setCalls($calls)->setSpreaders($spreader)->setPath('spreaders/calls.html')->render();
    }

    public function dismissed()
    {
        $data = new SpreadersBox;
        $data = $data->getDismissedSpreadersList();

        Renderer::me()->setSpreaders($data)->setPath('spreaders/dismissed.html')->render();
    }

    public function workArea()
    {
        $data = new SpreadersBox;
        $area = $data->getWorkAreaList($_GET);
        $spreader = $data->getSpreader($_GET);

        Renderer::me()->setArea($area)->setSpreaders($spreader)->setPath('spreaders/workArea.html')->render();
    }

    public function workAreaUpdate()
    {
        $data = new SpreadersBox;
        $area = $data->getWorkAreaSingle($_GET);
        $data = $data->getSpreader($_GET);

        Renderer::me()->setArea($area)->setSpreaders($data)->setPath('spreaders/workAreaUpdate.html')->render();
    }

    public function workAreaAdd()
    {
        $data = new SpreadersBox;
        $data = $data->getSpreader($_GET);

        Renderer::me()->setSpreaders($data)->setPath('spreaders/addWorkArea.html')->render();
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

        Renderer::me()->setSpreaders($data)->setPath('spreaders/files.html')->render();
    }

    public function actionAdd()
    {
        if ((new SpreadersBox)->addIt($_POST)) {
            header("Location: /spreaders/index");
        }
    }

    public function actionWorkAreaUpdate()
    {
        $id = $_POST['id'];
        (new SpreadersBox)->updateWorkArea($_POST);
        header("Location: /spreaders/workArea?id=$id");
    }

    public function actionWorkAreaAdd()
    {
        $id = $_POST['id'];
        (new SpreadersBox)->addWorkArea($_POST);
        header("Location: /spreaders/workArea?id=$id");
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
}
