<?php

class Orders
{
    public function getOrdersList()
    {
        $sql = "select * from orders";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $rows[$i]['id'] != null; $i++) {

            $rows[$i]['action'] = $this->getActionList($rows[$i]);

            $rows[$i]['status'] = Enum::GRAPHIC_ORDER_STATUS[$rows[$i]['status_id']];

            if ($rows[$i]['master_id'] != 0) {
                $user = (new UserBox)->getProfile($rows[$i]['master_id']);
                $rows[$i]['master_id'] = $user['first_name'] . $user['second_name'];
            } else {
                $id = $rows[$i]['id'];
                $rows[$i]['master_id'] = '<a href="/orders/updateMaster?id='.$id.'">Определить</a>';
            }
        }

        return $rows;
    }

    public function getActionList($row)
    {
        return OrderStatus::me()->getActionsForStatus($row);
    }

    public function getOrderCard()
    {
        $id = $_GET['id'];
        $sql = "select * from orders where id = '$id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);

        if ($row['status_id'] == 2) {
            $row['report_view'] = 'views/general/admin/orders/reports/final.html';
        } elseif ($row['status_id'] == 4) {
            $row['report_view'] = 'views/general/admin/orders/reports/afterCall.html';
        } else {
            $row['report_view'] = 'views/general/admin/orders/reports/standart.html';
        }

        $row['status'] = Enum::GRAPHIC_ORDER_STATUS[$row['status_id']];
        $row['page'] = $_GET['page'];

        return $row;
    }
}
