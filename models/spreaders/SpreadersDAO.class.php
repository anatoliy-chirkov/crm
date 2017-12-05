<?php

class SpreadersDAO
{
    public $id;
    public $name;
    public $homeAdress;
    public $phone;
    public $area;

    public static function me()
    {
        return new self;
    }

    public static function tableName()
    {
        return "spreaders";
    }

    public function parseForm($form)
    {
        $this->id = $form['id'];
        $this->name = $form['name'];
        $this->homeAdress = $form['home_adress'];
        $this->phone = $form['phone'];
        $this->area = $form['area'];

        return $this;
    }
}
