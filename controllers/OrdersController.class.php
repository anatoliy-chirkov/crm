<?php

class OrdersController
{
    public function index()
    {
        $data = (new Orders)->getOrdersList();

        Renderer::me()->setOrders($data)->setPath('orders/all.html')->render();
    }

    public function add()
    {
        Renderer::me()->setPath('orders/add.html')->render();
    }

    public function edit()
    {
        $data = new Orders;
        $data = $data->getOrderCard();

        Renderer::me()->setOrders($data)->setPath('orders/edit.html')->render();
    }

    public function card()
    {
        $data = new Orders;
        $data = $data->getOrderCard();

        Renderer::me()->setOrders($data)->setPath('orders/card.html')->render();
    }

    public function actionEdit()
    {
        if ((new OrderUpdater)->editOrder($_POST)) {
            header("Location: /orders/index");
        }
    }

    public function actionAdd()
    {
        if ((new OrderUpdater)->createOrder($_POST)) {
            header("Location: /orders/index");
        }
    }

    public function updateMaster()
    {
        $data = new UserBox;
        $data = $data->getUserList();

        Renderer::me()->setUsers($data)->setPath('orders/updateMaster.html')->render();
    }

    public function actionSetUser()
    {
        (new OrderUpdater)->setMaster();
        header("Location: /");

    }

    public function actionAddFile()
    {
        if ($_FILES["file"]["size"] > 1024 * 10 * 1024) {
            echo("Размер файла превышает 10 мегабайт");
            return false;
        }

        $path = 'files/';
        $ext = array_pop(explode('.', $_FILES['file']['name']));
        $fileName = time() . '.' . $ext;
        $filePath = $path . $fileName;

        if ($_FILES['file']['error'] == 0) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                $_POST['path'] = $fileName;
                $res = (new OrderUpdater)->addFileToOrder($_POST);
                if ($res)
                    return true;
            }
        }

        return false;
    }

    public function actionDelete()
    {
        if ((new OrderUpdater)->deleteOrder($_POST)) {
            header("Location: /orders/index");
        }
    }

    public function actionReport()
    {
        $id = $_POST['id'];

        (new OrderUpdater)->setReport($_POST);
        header("Location: /orders/card?id=$id");
    }
}
