<?php

class OrderStatusSetterController
{
    public function setStatus()
    {
        $statusId = $_GET['id'];
        $orderId = $_GET['order_id'];

        if ($statusId == 1) {
            $arrivalTime = $_POST['approve_arrival_time'];
            $sql = "UPDATE orders SET status_id = '$statusId', approve_arrival_time = '$arrivalTime' WHERE id = '$orderId'";
        } else {
            $sql = "UPDATE orders SET status_id = '$statusId' WHERE id = '$orderId'";
        }

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        header("Location: /orders/index");
    }
}
