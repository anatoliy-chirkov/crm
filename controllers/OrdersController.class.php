<?php

class OrdersController
{
    public function index()
    {
        $path = 'views/items/orders/admin/all.html';
        include('views/template/main.tpl.html');
    }
}
