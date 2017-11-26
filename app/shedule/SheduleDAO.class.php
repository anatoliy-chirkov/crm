<?php

class SheduleDAO
{
    public $id;
    public $date;
    public $userId;

    public static function me()
    {
        return new self;
    }

    public static function tableName()
    {
        return "shedule";
    }

    public function parseForm($form)
    {
        $this->id = $form['id'];
        $this->date = $form['date'];
        $this->userId = $form['user_id'];

        return $this;
    }
}
