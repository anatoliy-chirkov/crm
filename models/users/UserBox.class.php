<?php

class UserBox
{
    public function getUserList()
    {
        $sql = "select * from users";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetch(PDO::FETCH_ASSOC);

        return $rows;
    }
}
