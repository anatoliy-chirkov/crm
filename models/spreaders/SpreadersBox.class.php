<?php

class SpreadersBox
{
    public function addIt($form)
    {
        $data = SpreadersDAO::me()->parseForm($form);

        $sql = "insert into spreaders (first_name, second_name, home_adress, phone) 
                values ('$data->firstName', '$data->secondName', '$data->homeAdress', '$data->phone')";

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
