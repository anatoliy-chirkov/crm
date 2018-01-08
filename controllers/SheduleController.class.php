<?php

class SheduleController
{
    public function index()
    {
        if (AuthChecker::me()->isMainRole()) {
            $data = new UserBox;
            $masters = $data->getMasterList();
        } else {
            $masters['id'] = $_SESSION['id'];
            $masters['role'] = $_SESSION['role'];
        }

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
