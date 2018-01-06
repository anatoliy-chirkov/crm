<?php

class OrderUpdater
{
    public function createOrder($form)
    {
        $data = OrdersDAO::me()->parseForm($form);

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

    public function editOrder($form)
    {
        $data = OrdersDAO::me()->parseForm($form);

        $sql = "UPDATE orders SET 
                    name = '$data->name', 
                    phone = '$data->phone', 
                    metro = '$data->metro', 
                    area = '$data->area', 
                    adress = '$data->adress', 
                    arrival_day = '$data->arrivalDay', 
                    arrival_time = '$data->arrivalTime', 
                    problem = '$data->problem', 
                    master_id = '$data->masterId', 
                    status_id = '$data->statusId' 
                    WHERE id = '$data->id'";

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

    public function turnOrders($form)
    {
        $id = implode(", ", $form['id']);

        if ($form['action'] == 'delete') {
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
        } elseif ($form['action'] == 'close') {
            return true;
        }
    }

    public function updateOrderPerformanceStatus($form)
    {
        $data = OrdersDAO::me()->parseForm($form);

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
        $data = OrdersDAO::me()->parseForm($form);

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
