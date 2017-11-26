<?php

class Auth
{
    public function signUp($form)
    {
        $data = UserDAO::me()->parseForm($form);

        $sql =
            "insert login, password, first_name, phone, role 
              into users 
              values ($data->login, $data->password, $data->firstName, $data->phone, $data->role)";

        $res = DB::me()->getConnection()->prepare($sql);
        $res->execute();

        if ($res != null) {

            $data->id = DB::me()->getConnection()->lastInsertId();

            session_start();
            $_SESSION['id'] = $data->id;
            $_SESSION['role'] = $data->role;

            $hash = AuthUtils::generateHash();

            setcookie("hash", $hash, time()+60*60*24*30, "/");
            setcookie("id", $data->id, time()+60*60*24*30, "/");

            return true;

        } else {
            return false;
        }
    }

    /**
     * @param $form
     * @return boolean
     */
    public function signIn($form)
    {
        $data = UserDAO::me()->parseForm($form);

        $sql = "select id, login, password from users where login = $data->login";

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
            }
        }
    }

    public function logout()
    {
        setcookie("hash", "", time()-3600*24*30*12, "/");
        session_start();
        unset($_SESSION['session_username']);
        unset($_SESSION['is_auth']);
        unset($_SESSION["session_user_id"]);
        session_destroy();
    }
}
