<?php

class Calls
{
    public $id;
    public $number;
    public $orderId;
    public $initTime;
    public $endTime;
    public $comment;
    public $record;
    public $userId;
    public $callId;

    public function getCallsList()
    {
        $sql = "select * from calls order by id desc";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {

            $row['init_time'] = $row['init_time'] + 10800;
            $row['date'] = date('j M ', $row['init_time']) . date('G:i', $row['init_time']);

            if ($row['end_time']) {

                $row['end_time'] = $row['end_time'] + 10800;
                //$period = $row['end_time'] - $row['init_time'];

                if ($row['connected_time']) {
                    $duration = $row['end_time'] - $row['connected_time'];
                    $row['duration'] = date('i \м s \с', $duration);
                } else {
                    $row['duration'] = 'Пропущенный / Нет данных';
                }

                //$row['duration'] = date('G \ч i \м s \с', $period);
                $row['end_time'] = date('G:i', $row['end_time']);
            }

            if ($row['id'] < 25) {
                $row['duration'] = 'Нет данных';
            }

            if ($row['order_id'] == 0) {
                $row['order_id'] = null;
            }

            if ($row['recording_id'] == null || $row['recording_id'] == 0) {
                $row['record'] = '-';
            } else {
                $row['record'] = '<a href="' . VatsRequestBuilder::init()->getRecordingLink($row["recording_id"]) . '" class="btn btn-info">Открыть</a>';
            }
        }

        return $rows;
    }

    public function getCallsListForMaster($id)
    {
        $orders = (new Orders)->getOrdersListByMaster($id);

        foreach ($orders as $order) {
            $ordersIds = array();
            array_unshift($ordersIds, $order['id']);
            $ordersString = implode($ordersIds);
        }

        $sql = "select * from calls where order_id in ('$ordersString') order by id desc";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {

            $row['init_time'] = $row['init_time'] + 10800;
            $row['date'] = date('j M ', $row['init_time']) . date('G:i', $row['init_time']);

            if ($row['end_time']) {

                $row['end_time'] = $row['end_time'] + 10800;
                $period = $row['end_time'] - $row['init_time'];

                $row['duration'] = date('G \ч i \м s \с', $period);
                $row['end_time'] = date('G:i', $row['end_time']);
            }

            if ($row['id'] < 25) {
                $row['duration'] = 'Нет данных';
            }

            if ($row['order_id'] == 0) {
                $row['order_id'] = null;
            }

            if ($row['recording_id'] == null || $row['recording_id'] == 0) {
                $row['record'] = '-';
            } else {
                $row['record'] = '<a href="' . VatsRequestBuilder::init()->getRecordingLink($row["recording_id"]) . '" class="btn btn-info">Открыть</a>';
            }
        }

        return $rows;
    }

    public function getCallsListForOrder($id)
    {
        $sql = "select * from calls where order_id = '$id' order by id desc";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {

            $row['init_time'] = $row['init_time'] + 10800;
            $row['date'] = date('j M ', $row['init_time']) . date('G:i', $row['init_time']);

            if ($row['end_time']) {

                $row['end_time'] = $row['end_time'] + 10800;
                //$period = $row['end_time'] - $row['init_time'];

                if ($row['connected_time']) {
                    $duration = $row['end_time'] - $row['connected_time'];
                    $row['duration'] = date('i \м s \с', $duration);
                } else {
                    $row['duration'] = 'Пропущенный / Нет данных';
                }

                //$row['duration'] = date('G \ч i \м s \с', $period);
                $row['end_time'] = date('G:i', $row['end_time']);
            }

            if ($row['id'] < 25) {
                $row['duration'] = 'Нет данных';
            }

            if ($row['order_id'] == 0) {
                $row['order_id'] = null;
            }

            if ($row['recording_id'] == null || $row['recording_id'] == 0) {
                $row['record'] = '-';
            } else {
                $row['record'] = '<a href="' . VatsRequestBuilder::init()->getRecordingLink($row["recording_id"]) . '" class="btn btn-info">Открыть</a>';
            }
        }

        return $rows;
    }

    public function init($userId, $toPhone)
    {
        $sql = "select * from users where id = '$userId'";
        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetch(PDO::FETCH_ASSOC);
        $fromPhone = $rows['phone'];

        VatsRequestBuilder::init()->initCall($fromPhone, $toPhone);
    }
}
