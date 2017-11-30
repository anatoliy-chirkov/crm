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

    public function addIt($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        $sql = "insert into spreaders (first_name, second_name, home_adress, phone, area) 
                values ('$data->firstName', '$data->secondName', '$data->homeAdress', '$data->phone', '$data->area')";

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
}
