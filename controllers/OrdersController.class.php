<?php

class OrdersController
{
    public function index()
    {
        if (AuthChecker::me()->isMainRole()) {
            $data = (new Orders)->getOrdersList();
        } else {
            $data = (new Orders)->getOrdersListByMaster($_SESSION['id']);
        }

        Renderer::me()->setOrders($data)->setCountOfElements($data)->setPath('orders/all.html')->render();
    }

    public function add()
    {
        $data = new UserBox;
        $masters = $data->getMasterList();

        Renderer::me()->setUsers($masters)->setPath('orders/add.html')->render();
    }

    public function edit()
    {
        $orderData = new Orders;
        $order = $orderData->getOrderCard();

        $userData = new UserBox;
        $masters = $userData->getMasterList();

        $statuses = Enum::GRAPHIC_ORDER_STATUS;

        Renderer::me()->setOrders($order)->setStatuses($statuses)->setUsers($masters)->setPath('orders/edit.html')->render();
    }

    public function card()
    {
        $orderData = new Orders;
        $order = $orderData->getOrderCard();

        Renderer::me()->setOrders($order)->setPath('orders/card.html')->render();
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

    public function actionTurn()
    {
        (new OrderUpdater)->turnOrders($_POST);

        header("Location: /orders/index");
    }

    public function actionReport()
    {
        $id = $_POST['id'];

        (new OrderUpdater)->setReport($_POST);
        header("Location: /orders/card?id=$id");
    }
}
