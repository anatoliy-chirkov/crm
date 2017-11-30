<?php

class OrdersController
{
    public function index()
    {
        $data = (new OrderBox)->getOrdersList();

        $usersForApprove = new UserBox;
        $usersForApprove = $usersForApprove->getUserList();

        $path = 'views/items/orders/admin/all.html';
        include('views/template/main.tpl.html');
    }

    public function add()
    {
        $path = 'views/items/orders/admin/add.html';
        include('views/template/main.tpl.html');
    }

    public function card()
    {
        $data = new OrderBox;
        $data = $data->getOrderCard();

        $path = 'views/items/orders/admin/card.html';
        include('views/template/main.tpl.html');
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

        $path = 'views/items/orders/admin/updateMaster.html';
        include('views/template/main.tpl.html');
    }

    public function actionSetUser()
    {
        (new OrderUpdater)->setMaster();
        header("Location: /");

    }

    public function addFile()
    {
        if ($_FILES["filename"]["size"] > 1024 * 10 * 1024) {
            echo("Размер файла превышает 10 мегабайт");
            return false;
        }

        $path = 'files/';
        $ext = array_pop(explode('.', $_FILES['filename']['name']));
        $fileName = time() . '.' . $ext;
        $filePath = $path . $fileName;

        if ($_FILES['filename']['error'] == 0) {
            if (move_uploaded_file($_FILES['filename']['tmp_name'], $filePath)) {
                $_POST['image_src'] = $fileName;
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
}
