<?php

class SheduleBox
{
    public function getPersonalShedule($id)
    {
        $sql = "select * from shedule where user_id = $id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetch(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function getGeneralShedule()
    {
        $sql = "select * from shedule";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetch(PDO::FETCH_ASSOC);

        return $rows;
    }
}
