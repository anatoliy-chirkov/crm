<?php

class Renderer
{
    public $orders;
    public $users;
    public $calls;
    public $shedule;
    public $news;
    public $spreaders;
    public $statuses;

    protected $path;

    public static function me()
    {
        return new self;
    }

    public function setOrders($data)
    {
        $this->orders = $data;
        return $this;
    }

    public function setUsers($data)
    {
        $this->users = $data;
        return $this;
    }

    public function setCalls($data)
    {
        $this->calls = $data;
        return $this;
    }

    public function setShedule($data)
    {
        $this->shedule = $data;
        return $this;
    }

    public function setNews($data)
    {
        $this->news = $data;
        return $this;
    }

    public function setSpreaders($data)
    {
        $this->spreaders = $data;
        return $this;
    }

    public function setStatuses($data)
    {
        $this->statuses = $data;
        return $this;
    }


    public function setPath($data)
    {
        $checker = new AuthChecker();

        if ($checker->isMaster()) {
            $user = 'master';
        } else if ($checker->isOperator()) {
            $user = 'operator';
        } else if ($checker->isHr()) {
            $user = 'hr';
        } else if ($checker->isAdmin()) {
            $user = 'admin';
        } else {
            $this->path = 'views/general/common/auth/index.html';
            return $this;
        }

        $this->path = 'views/general/'.$user.'/'.$data;
        return $this;
    }

    public function render()
    {
        $orders = $this->orders;
        $users = $this->users;
        $calls = $this->calls;
        $shedule = $this->shedule;
        $news = $this->news;
        $spreaders = $this->spreaders;
        $statuses = $this->statuses;

        $menu = $this->getMenu();
        $path = $this->path;
        include('views/template/main.tpl.html');
    }

    /*
     * Renderer::me()->setOrders($data)->setUsers($users)->setPath('orders/all.html')->render();
     *
     * With Singleton maybe make "smart-back-button"
     * Method: renderLastPage() / back()
     */

    public function getMenu()
    {
        $checker = new AuthChecker();

        if ($checker->isMaster()) {
            $menu = 'views/general/master/template/points.html';
        } else if ($checker->isOperator()) {
            $menu = 'views/general/operator/template/points.html';
        } else if ($checker->isHr()) {
            $menu = 'views/general/hr/template/points.html';
        } else if ($checker->isAdmin()) {
            $menu = 'views/general/admin/template/points.html';
        } else {
            $menu = null;
        }

        return $menu;
    }
}
