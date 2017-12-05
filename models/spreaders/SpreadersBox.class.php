<?php

class SpreadersBox
{
    public function getSpreadersList()
    {
        $sql = "select * from spreaders";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        //в rows засетить нужные параметры
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

    public function addIt($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        $sql = "insert into spreaders (name, home_adress, phone, area) 
                values ('$data->name', '$data->homeAdress', '$data->phone', '$data->area')";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteIt($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        $sql = "delete from spreaders where id = '$data->id'";

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

        $sql = "update spreaders set name='$data->name', home_adress='$data->homeAdress', phone='$data->phone', area='$data->area' where id = '$data->id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }
}
