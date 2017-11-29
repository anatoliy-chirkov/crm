<?php

class OrderUpdater
{
    public function createOrder($form)
    {
        $data = OrderDAO::me()->parseForm($form);
        $dataString = $data->toString();

        $sql = "insert into orders values ($dataString)";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function addFileToOrder($data)
    {
        $path = $data['path'];
        $id = $data['id'];

        $sql = "UPDATE files SET path = '$path' WHERE order_id = '$id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOrder($form)
    {
        $data = OrderDAO::me()->parseForm($form);
        //$dataString = $data->toString();

        $sql = "delete from orders where id = '$data->id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOrderStatus($form)
    {
        $data = OrderDAO::me()->parseForm($form);

        $sql = "insert status_id into orders values ($data->statusId) where id = $data->id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOrderReport($form)
    {
        $data = OrderDAO::me()->parseForm($form);

        $sql = "insert report into orders values ($data->report) where id = $data->id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function updateOrderPerformanceStatus($form)
    {
        $data = OrderDAO::me()->parseForm($form);

        $sql = "insert performance_status_id into orders values ($data->performanceStatusId) where id = $data->id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePaymentStatus($form)
    {
        $data = OrderDAO::me()->parseForm($form);

        $sql = "insert payment_status into orders values ($data->paymentStatus) where id = $data->id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }
}
