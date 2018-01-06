<?php

class SheduleController
{
    public function index()
    {
        $data = new UserBox;
        $masters = $data->getMasterList();

        Renderer::me()->setUsers($masters)->setPath('shedule/index.html')->render();
    }

    public function setDates()
    {
        $id = $_POST['user_id'];
        $jsonDates = json_encode($_POST['dates']);

        $sql = "UPDATE users SET shedule = '$jsonDates' WHERE id = '$id'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
    }
}
