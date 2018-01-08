<?php

class OrderReportSetterController
{
    public function setReport()
    {
        $statusId = $_POST['status_id'];
        $orderId = $_POST['id'];
        $report = $_POST['report'];

        if ($statusId == 3) {
            $orderAmount = $_POST['order_amount'];
            $expensesAmount = $_POST['expenses_amount'];
            $finalAmount = $orderAmount - $expensesAmount;

            if ($finalAmount < 10000) {
                $salaryAmount = $finalAmount * 0.4;
            } else {
                $salaryAmount = $finalAmount * 0.5;
            }

            $taxAmount = $finalAmount - $salaryAmount;

            $sql = "UPDATE orders SET 
                    status_id = '$statusId', 
                    report = '$report', 
                    order_amount = '$orderAmount', 
                    expenses_amount = '$expensesAmount',
                    salary_amount = '$salaryAmount',
                    tax_amount = '$taxAmount' 
                    WHERE id = '$orderId'";
        } elseif ($statusId == 5) {
            $sql = "UPDATE orders SET status_id = '$statusId', report = '$report' WHERE id = '$orderId'";
        } elseif ($statusId == 6 || $statusId == 7) {
            $day = $_POST['arrival_day'];
            $time = $_POST['arrival_time'];
            $sql = "UPDATE orders SET 
                    status_id = '$statusId', 
                    report = '$report',
                    arrival_day = '$day', 
                    arrival_time = '$time' 
                    WHERE id = '$orderId'";
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
