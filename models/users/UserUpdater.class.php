<?php

class UserUpdater
{
    public function changePassword()
    {

    }

    public function changeName()
    {

    }

    public function deleteIt($form)
    {
        $data = UserDAO::me()->parseForm($form);

        $sql = "delete from users where id = '$data->id'";

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
        $data = UserDAO::me()->parseForm($form);

        $sql = "update users set 
                role='$data->role', 
                login='$data->login', 
                first_name='$data->firstName', 
                second_name='$data->secondName',
                phone='$data->phone',
                password='$data->password' 
                where id = '$data->id'"
        ;

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {
            return true;
        } else {
            return false;
        }
    }
}
