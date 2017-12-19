<?php

class OrdersController
{
    public function index()
    {
        $data = (new OrderBox)->getOrdersList();

        Renderer::me()->setOrders($data)->setPath('orders/all.html')->render();
    }

    public function add()
    {
        Renderer::me()->setPath('orders/add.html')->render();
    }

    public function card()
    {
        $data = new OrderBox;
        $data = $data->getOrderCard();

        Renderer::me()->setOrders($data)->setPath('orders/card.html')->render();
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

    /**
     * @param id, user_id, report_type $_GET
     */
    public function report()
    {
        $data = new UserDAO;
        $data = $data->parseForm($_GET);

        switch ($_GET['report_type']) {
            case 1:
                Renderer::me()->setOrders($data)->setPath('orders/reports/1.html')->render();
                break;
            case 2:
                Renderer::me()->setOrders($data)->setPath('orders/reports/2.html')->render();
                break;
            case 3:
                Renderer::me()->setOrders($data)->setPath('orders/reports/3.html')->render();
                break;
        }
    }

    public function actionReport()
    {
        $id = $_POST['id'];

        (new OrderUpdater)->setReport($_POST);
        header("Location: /orders/card?id=$id");
    }

    public function getActionList()
    {
        /*
         * Доступные действия
         * ссылки одинаковые (кроме просмотра)
         */

        $id = $_GET['id'];
        $status_id = $_GET['status_id'];

        if ($status_id == 1) {

            $actions =
                '<a href="orders/report1?id=$id&status_id=1">Заказ выполнен</a>'.
                '<br>'.
                '<a href="orders/report1?id=$id">Отчет</a>';

        } else if ($status_id == 2) {

            $actions =
                '<a href="orders/report2?id=$id&status_id=2">Прибыл на заказ</a>'.
                '<br>'.
                '<a href="orders/report2?id=$id">Отчет</a>';

        } else if ($status_id == 3) {

            $actions =
                '<a href="orders/report3?id=$id&status_id=2">Решаю</a>'.
                '<a href="orders/report3?id=$id&status_id=2">Перенос</a>'.
                '<br>'.
                '<a href="orders/report3?id=$id">Отчет</a>';

        } else if ($status_id == 2) {

            $actions =
                '<a href="orders/report1?id=$id&status_id=2">Прибыл на заказ</a>'.
                '<br>'.
                '<a href="orders/report1?id=$id">Отчет</a>';

        }

        //to do (if ...)

        return $actions;
    }
}
