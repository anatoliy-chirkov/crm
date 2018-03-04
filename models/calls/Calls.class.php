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

    public function getCallsList($outgoing = null)
    {
        if ($outgoing == null) {
            $sql = "select * from calls where outgoing is null order by id desc";
        } else {
            $sql = "select * from calls where outgoing = 1 order by id desc";
        }

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
                    $row['duration'] = 'Не взяли трубку (нет данных)';
                }

                //$row['duration'] = date('G \ч i \м s \с', $period);
                $row['end_time'] = date('G:i', $row['end_time']);
            }

            if ($row['id'] < 58) {
                $row['duration'] = 'Нет данных';
            }

            if ($row['order_id'] == 0) {
                $row['order_id'] = null;
            }

            if ($row['order_id'] == null) {
                $row['order'] = '<a href="/orders/add?phone='. $row["number"] .'" type="button" class="btn btn-primary btn-xs">Создать</a>';
            } else {
                $row['order'] = '<a href="/orders/card?id='. $row["order_id"].'">'. $row["order_id"] .'</a>';
            }

            if ($row['recording_id'] == null) {
                $row['record'] = '-';
            } else {
                $row['record'] = '<a href="' . VatsRequestBuilder::init()->getRecordingLink($row["recording_id"]) . '" class="btn btn-info">Открыть</a>';
            }
        }

        return $rows;
    }

    public function getCallsListForMaster($id, $outgoing = null)
    {
        $orders = (new Orders)->getOrdersListByMaster($id);

        foreach ($orders as $order) {
            $ordersIds = array();
            array_unshift($ordersIds, $order['id']);
            $ordersString = implode($ordersIds);
        }

        if ($outgoing = null) {
            $sql = "select * from calls where order_id in ('$ordersString') and outgoing is null order by id desc";
        } else {
            $sql = "select * from calls where order_id in ('$ordersString') and outgoing = 1 order by id desc";
        }

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

            if ($row['recording_id'] == null) {
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

            if ($row['recording_id'] == null) {
                $row['record'] = '-';
            } else {
                $row['record'] = '<a href="' . VatsRequestBuilder::init()->getRecordingLink($row["recording_id"]) . '" class="btn btn-info">Открыть</a>';
            }

            if ($row['outgoing'] == null || $row['outgoing'] == 0) {
                $row['type'] = 'Входящий';
            } else {
                $row['type'] = 'Исходящий';
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
