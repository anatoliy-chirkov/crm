<?php

class SpreadersDAO
{
    public $id;
    public $firstName;
    public $secondName;
    public $homeAdress;
    public $phone;

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
        $this->firstName = $form['first_name'];
        $this->secondName = $form['second_name'];
        $this->homeAdress = $form['home_adress'];
        $this->phone = $form['phone'];

        return $this;
    }
}
