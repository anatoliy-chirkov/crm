<?php

class SheduleUpdater
{
    public function setDate($form)
    {
        $data = SheduleDAO::me()->parseForm($form);

        $sql = "insert date, user_id into users values ($data->date, $data->userId)";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        }

        return false;
    }

    public function unsetDate($form)
    {
        $data = SheduleDAO::me()->parseForm($form);

        $sql = "delete from shedule where id = $data->id";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        }

        return false;
    }
}
