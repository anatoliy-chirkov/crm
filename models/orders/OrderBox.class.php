<?php

class OrderBox
{
    public function getOrdersList()
    {
        $sql = "select * from orders";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetch(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function getOrderCard($id)
    {
        $sql = "select * from orders where id = $id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);

        return $row;
    }
}
