<?php

class SpreadersBox
{
    public function getSpreadersList()
    {
        $sql = "select * from spreaders where dismissed is null";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        //в rows засетить нужные параметры
        return $rows;
    }

    public function getDismissedSpreadersList()
    {
        $sql = "select * from spreaders where dismissed = 1";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function getSpreader($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        $sql = "select * from spreaders where id = '$data->id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $row = $res->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function getWorkAreaList($form)
    {
        $id = $form['id'];

        $sql = "select * from spreaders_area where spreader_id = $id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $row = $res->fetchAll(PDO::FETCH_ASSOC);

        if ($row == null) {
            $sql = "insert into spreaders_area (spreader_id) values ($id)";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();

            $sql = "select * from spreaders_area where spreader_id = $id";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $row = $res->fetchAll(PDO::FETCH_ASSOC);
        }

        return $row;
    }

    public function getWorkAreaSingle($form)
    {
        $id = $form['id'];

        $sql = "select * from spreaders_area where spreader_id = $id";

        try {
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $row = $res->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $row = null;
        }

        return $row;
    }

    public function getCallsBySpreader($form)
    {
        $id = $form['id'];

        $sql = "select * from spreaders_calls where spreader_id = '$id' order by id desc";
        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        setlocale(LC_ALL, 'ru_RU.UTF-8');

        foreach ($rows as &$row) {

            $row['first_call_time'] = $row['first_call_time'] + 10800;
            $row['date'] = date('j M y', $row['first_call_time']);

            if ($row['second_call_time']) {

                $row['second_call_time'] = $row['second_call_time'] + 10800;
                $period = $row['second_call_time'] - $row['first_call_time'];

                $row['period'] = date('G \ч i \м\и\н', $period);
                $row['second_call_time'] = date('G:i', $row['second_call_time']);
            }

            $row['first_call_time'] = date('G:i', $row['first_call_time']);
        }

        return $rows;
    }

    public function addIt($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        $sql = "insert into spreaders (name, home_adress, phone, area, comment) 
                values ('$data->name', '$data->homeAdress', '$data->phone', '$data->area', '$data->comment')";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        $lastId = DB::me()->getConnection()->lastInsertId();

        $sql = "insert into spreaders_area (spreader_id) 
                values ($lastId)";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function addWorkArea($form)
    {
        $mon = $form['mon'];
        $tue = $form['tue'];
        $wed = $form['wed'];
        $thu = $form['thu'];
        $fri = $form['fri'];
        $sat = $form['sat'];
        $sun = $form['sun'];
        $id = $form['id'];

        $sql = "insert into spreaders_area (spreader_id, mon, tue, wed, thu, fri, sat, sun) 
                values ($id, '$mon', '$tue', '$wed', '$thu', '$fri', '$sat', '$sun')";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
    }

    public function deleteIt($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        if ($form['really'] == 1) {
            $sql = "delete from spreaders where id = '$data->id'";
        } elseif ($form['cancel'] == 1) {
            $sql = "update spreaders set dismissed = null where id = '$data->id'";
        } else {
            $sql = "update spreaders set dismissed = 1 where id = '$data->id'";
        }

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function updateIt($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        $sql = "update spreaders set name='$data->name', home_adress='$data->homeAdress', phone='$data->phone', area='$data->area', comment='$data->comment' where id = '$data->id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function updateWorkArea($form)
    {
        $mon = $form['mon'];
        $tue = $form['tue'];
        $wed = $form['wed'];
        $thu = $form['thu'];
        $fri = $form['fri'];
        $sat = $form['sat'];
        $sun = $form['sun'];
        $id = $form['id'];

        $sql = "update spreaders_area set mon='$mon', tue='$tue', wed='$wed', thu='$thu', fri='$fri', sat='$sat', sun='$sun' where spreader_id = $id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($mon != 0 or $mon != null) {
            $sql = "update spreaders set area = null where id = $id";
            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
        }
    }
}
