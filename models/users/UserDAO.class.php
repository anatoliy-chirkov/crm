<?php

class UserDAO
{
    public $id;
    public $login;
    public $password;
    public $hash;
    public $firstName;
    public $secondName;
    public $debt;
    public $tariff;
    public $phone;
    public $email;
    public $document;
    public $homeAdress;
    public $role;

    public static function me()
    {
        return new self;
    }

    public static function tableName()
    {
        return "users";
    }

    public function parseForm($form)
    {
        $this->id = $form['id'];
        $this->login = $form['login'];
        $this->password = $form['password'];
        $this->hash = $form['hash'];
        $this->login = $form['login'];
        $this->firstName = $form['first_name'];
        $this->secondName = $form['second_name'];
        $this->debt = $form['debt'];
        $this->tariff = $form['tariff'];
        $this->phone = $form['phone'];
        $this->email = $form['email'];
        $this->document = $form['document'];
        $this->homeAdress = $form['home_adress'];
        $this->role = $form['role'];

        return $this;
    }
}
