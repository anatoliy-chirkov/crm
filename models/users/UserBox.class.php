<?php

class UserBox
{
    public function getUserList()
    {
        $sql = "select * from users";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $rows[$i]['role'] != null; $i++) {
            $rows[$i]['role'] = Enum::ROLES[$rows[$i]['role']];
        }

        //в rows засетить нужные параметры
        return $rows;
    }

    public function getMasterList()
    {
        $sql = "select * from users where role = 1";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function getProfile($id = null)
    {
        if (empty($id)) {
            $id = $_GET['id'];
        }
        $sql = "select * from users where id = '$id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetch(PDO::FETCH_ASSOC);

        $rows['role_id'] = $rows['role'];
        $rows['role'] = Enum::ROLES[$rows['role']];

        //в rows засетить нужные параметры
        return $rows;
    }
}
