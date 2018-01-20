<?php

class AjaxController
{
    public function getFinalReportFields()
    {
        $statusId = $_POST['status_id'];

        if ($statusId == 3) {
            echo
                '<div class="form-group">
                    <label for="input3" class=" control-label">Сумма заказа (руб.)</label>
                    <input name="order_amount" type="number" class="form-control" id="input3">
                </div>
                <div class="form-group">
                    <label for="input4" class=" control-label">Расходы (руб.)</label>
                    <input name="expenses_amount" type="number" class="form-control" id="input4">
                </div>';
        } elseif ($statusId == 6 || $statusId == 7) {
            echo
                '<div class="form-group">
                    <label for="input6" class=" control-label">Следующая дата прибытия</label>
                    <input name="arrival_day" type="date" class="form-control" id="input6">
                </div>
                <div class="form-group">
                    <label for="input6" class=" control-label">Время прибытия</label>
                    <input name="arrival_time" type="time" class="form-control" id="input6">
                </div>';
        }
    }

    public function getSheduleForMaster()
    {
        $id = $_POST['id'];

        $sql = "select shedule from users where id = $id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);

        $dates = $row['shedule'];

        print_r($dates);
    }

    public function setSheduleForMaster()
    {
        $id = $_POST['id'];
        $shedule = json_encode($_POST['dates']);

        $sql = "UPDATE users SET shedule = '$shedule' WHERE id = '$id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
    }

    public function getSessionData()
    {
        echo json_encode($_SESSION);
    }

    public function getOrders()
    {
        $now = time() + 10800;

        if ($_POST['date'] == 'all') {

            $sql = "select * from orders";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));

        } elseif ($_POST['date'] == 'yesterday') {

            $date = date("Y-m-d", $now);
            $dateDay = substr($date, 8, 2) - 1;
            $date = substr($date, 0, 8) . $dateDay;

            $from = strtotime($date . " 00:00:00");
            $to = strtotime($date . " 23:59:59");

            $sql = "select * from orders where order_create between $from and $to";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));

        } elseif ($_POST['date'] == 'today') {

            $date = date("Y-m-d", $now);

            $from = strtotime($date . " 00:00:00");
            $to = strtotime($date . " 23:59:59");

            $sql = "select * from orders where order_create between $from and $to";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));

        } elseif ($_POST['date'] == 'week') {
            $dateFrom = date("Y-m-d", $now - 604800);
            $dateTo = date("Y-m-d", $now);

            $from = strtotime($dateFrom . " 00:00:00");
            $to = strtotime($dateTo . " 23:59:59");

            $sql = "select * from orders where order_create between $from and $to";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));
        }

        if ($_POST['status'] == 'all') {
            $sql = "select * from orders";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));
        } elseif ($_POST['status'] == 'work') {
            $sql = "select * from orders where status_id = 0";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));
        } elseif ($_POST['status'] == 'without_pay') {
            $sql = "select * from orders where status_id = 3 and payment_status = 0";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);

            $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));
        }
    }

    public function getOrdersInOneDay()
    {
        $from = strtotime($_POST['date'] . " 00:00:00");
        $to = strtotime($_POST['date'] . " 23:59:59");

        $sql = "select * from orders where status_id = 3 and order_create between $from and $to";
        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        $this->ordersPartialView(Orders::me()->updateOrdersResult($rows));
    }

    private function ordersPartialView($orders)
    {
        echo
        '<table class="table table-striped">
        <tr>
            <th>*</th>
            <th>Id</th>
            <th>Дата приезда</th>
            <th>ФИО</th>
            <th>Адрес</th>
            <th>Описание</th>
            <th>Мастер</th>
            <th>Статус</th>
            <th>Действия</th>
            <th>Просмотр</th>
        </tr>';

        foreach($orders as $orders):

        echo '<tr>
            <td><div class="form-group"><input type="checkbox" name="id[]" value="'.$orders["id"].'"></div></td>
            <td><a href="/orders/card?id='.$orders["id"].'">'.$orders["id"].'</a></td>
            <td>'.$orders["arrival_date"].' '.$orders["arrival_time"].'</td>
            <td>'.$orders["name"].'</td>
            <td>'.$orders["adress"].'</td>
            <td>'.$orders["problem"].'</td>
            <td><a href="/users/profile?id='.$orders["id"].'">'.$orders["master_id"].'</a></td>
            <td>'.$orders["status"].'</td>
            <td>'.$orders["action"].'</td>
            <td><a href="/orders/card?id='.$orders["id"].'" class="btn btn-default">Посмотр</a></td>
        </tr>';
        
        endforeach;
        
        echo '</table>';
    }
}
