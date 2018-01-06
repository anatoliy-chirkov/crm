<?php

class OrderUpdater
{
    public function createOrder($form)
    {
        $data = OrderDAO::me()->parseForm($form);

        $sql = "insert into orders 
                (
                    name, 
                    phone, 
                    metro, 
                    area, 
                    adress, 
                    arrival_day, 
                    arrival_time, 
                    problem, 
                    master_id, 
                    operator_id, 
                    status_id, 
                    order_create
                ) values 
                (
                    '$data->name', 
                    '$data->phone', 
                    '$data->metro', 
                    '$data->area', 
                    '$data->adress', 
                    '$data->arrivalDay', 
                    '$data->arrivalTime', 
                    '$data->problem', 
                    '$data->masterId', 
                    '$data->operatorId', 
                    '$data->statusId', 
                    '$data->orderCreate'
                )";

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

    public function setMaster()
    {
        $id = $_GET['id'];
        $master_id = $_GET['master_id'];

        $sql = "UPDATE orders SET master_id = '$master_id' WHERE id = '$id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null)
            return true;

        return false;
    }

    /**
     * @param $form
     */
    public function setReport($form)
    {
        $data = OrderDAO::me()->parseForm($form);

        switch ($form['report_type']) {

            case 1:

                $sql = "UPDATE orders SET status_id = '$data->statusId', report = '$data->report' WHERE id = '$data->id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
                return;

            case 2:

                $sql = "UPDATE orders SET status_id = '$data->statusId', report = '$data->report' WHERE id = '$data->id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
                return;

            case 3:

                $sql = "UPDATE orders SET status_id = '$data->statusId', report = '$data->report' WHERE id = '$data->id'";
                $res = DB::me()->getConnection()->prepare($sql);
                $res->execute();
                return;

        }
    }

    public function deleteOrder($form)
    {
        $id = implode(", ", $form['id']);

        if (strripos($id, ',')) {
            $sql = "delete from orders where id IN ($id)";
        } else {
            $sql = "delete from orders where id = '$id'";
        }

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
