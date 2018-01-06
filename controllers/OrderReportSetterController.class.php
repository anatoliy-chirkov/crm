<?php

class OrderReportSetterController
{
    public function setReport()
    {
        $statusId = $_POST['status_id'];
        $orderId = $_POST['id'];
        $report = $_POST['report'];

        if ($statusId == 3) {
            $cash = $_POST['money'];
            $sql = "UPDATE orders SET status_id = '$statusId', report = '$report' WHERE id = '$orderId'";
        } elseif ($statusId == 5) {
            $sql = "UPDATE orders SET status_id = '$statusId', report = '$report' WHERE id = '$orderId'";
        } elseif ($statusId == 6 || $statusId == 7) {
            $date = $_POST['arrival_day'];
            $time = $_POST['arrival_time'];
            $sql = "UPDATE orders SET status_id = '$statusId', report = '$report' WHERE id = '$orderId'";
        }

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        header("Location: /orders/card?id=$orderId");
    }

    public function setReportAndStatus()
    {
        $statusId = $_POST['id'];
        $orderId = $_POST['order_id'];
        $report = $_POST['report'];

        $sql = "UPDATE orders SET status_id = '$statusId', report = '$report' WHERE id = '$orderId'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        header("Location: /orders/index");
    }

    public function setReportWithoutStatus()
    {
        $orderId = $_POST['order_id'];
        $report = $_POST['report'];

        $sql = "UPDATE orders SET report = '$report' WHERE id = '$orderId'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        header("Location: /orders/card?id=$orderId");
    }

    public function setTransferReport()
    {
        $statusId = $_POST['id'];
        $orderId = $_POST['order_id'];
        $report = $_POST['report'];
        //время приезда, дата приезда

        $sql = "UPDATE orders SET status_id = '$statusId', report = '$report' WHERE id = '$orderId'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        header("Location: /orders/index");
    }

    public function setSuccessReport()
    {
        $statusId = $_POST['id'];
        $orderId = $_POST['order_id'];
        $report = $_POST['report'];
        //сумма денег заказа, сумма оплаты в казну

        $sql = "UPDATE orders SET status_id = '$statusId', report = '$report' WHERE id = '$orderId'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        header("Location: /orders/index");
    }
}
