<?php

class OrderReportSetterController
{
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
