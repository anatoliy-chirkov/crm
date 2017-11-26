<?php

class AuthChecker
{
    public function isHr()
    {
        if ($_SESSION['role'] === 3)
            return true;

        return false;
    }

    public function isMaster()
    {
        if ($_SESSION['role'] === 1)
            return true;

        return false;
    }

    public function isOperator()
    {
        if ($_SESSION['role'] === 2)
            return true;

        return false;
    }

    public function isAdmin()
    {
        if ($_SESSION['role'] === 4)
            return true;

        return false;
    }
}
