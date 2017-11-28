<?php

class OrdersController
{
    public function index()
    {
        $data = (new OrderBox)->getOrdersList();

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
        $path = 'views/items/orders/admin/card.html';
        include('views/template/main.tpl.html');
    }

    public function actionAdd()
    {
        if ((new OrderUpdater)->createOrder($_POST)) {
            header("Location: /orders/index");
        }
    }

    public function actionDelete()
    {
        if ((new OrderUpdater)->deleteOrder($_POST)) {
            header("Location: /orders/index");
        }
    }
}
