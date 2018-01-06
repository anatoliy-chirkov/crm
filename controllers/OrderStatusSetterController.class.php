<?php

class OrderStatusSetterController
{
    public function setStatus()
    {
        $statusId = $_GET['id'];
        $orderId = $_GET['order_id'];

        $sql = "UPDATE orders SET status_id = '$statusId' WHERE id = '$orderId'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        header("Location: /orders/index");
    }
}
