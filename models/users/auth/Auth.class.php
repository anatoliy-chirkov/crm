<?php

class Auth
{
    public function signUp($form)
    {
        $data = UserDAO::me()->parseForm($form);

        $sql =
            "insert into users (login, password, first_name, phone, role) 
              values ('$data->login', '$data->password', '$data->firstName', '$data->phone', '$data->role')";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null)
            return true;

        return false;
    }

    /**
     * @param $form
     * @return boolean
     */
    public function signIn($form)
    {
        $data = UserDAO::me()->parseForm($form);

        $sql = "SELECT id, login, password, role FROM users WHERE login = '$data->login'";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();
        $rows = $res->fetch(PDO::FETCH_ASSOC);

        if ($rows['password'] == $data->password) {

            session_start();
            $_SESSION['id'] = $rows['id'];
            $_SESSION['role'] = $rows['role'];

            $hash = AuthUtils::generateHash();

            setcookie("hash", $hash, time()+60*60*24*30, "/");
            setcookie("id", $rows['id'], time()+60*60*24*30, "/");

            return true;

        } else {
            return false;
        }
    }

    public function signInAuto()
    {
        if ($_COOKIE['id'] & $_COOKIE['hash']) {

            $data = UserDAO::me()->parseForm($_COOKIE);

            $sql = "select id, hash, role from users where id = $data->id";

            $res = DB::me()->getConnection()->prepare($sql);
            $res->execute();
            $rows = $res->fetch(PDO::FETCH_ASSOC);

            if ($rows['hash'] == $data->hash) {
                session_start();
                $_SESSION['id'] = $rows['id'];
                $_SESSION['role'] = $rows['role'];

                return true;
            }
        }

        return false;
    }

    public function logout()
    {
        setcookie("id", "", time()-3600*24*30*12, "/");
        setcookie("hash", "", time()-3600*24*30*12, "/");
        session_start();
        unset($_SESSION['id']);
        unset($_SESSION["role"]);
        session_destroy();
    }
}
