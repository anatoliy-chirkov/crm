<?php

class OrdersDAO
{
    public $id;
    public $name;
    public $phone;
    public $homePhone;
    public $arrivalDay;
    public $arrivalTime;
    public $materials;
    public $operatorId;
    public $statusId;
    public $metro;
    public $area;
    public $adress;
    public $problem;
    public $orderCreate;
    public $masterId;
    public $performanceStatusId;
    public $paymentStatus;
    public $report;
    public $reportDate;

    public static function me()
    {
        return new self;
    }

    public static function tableName()
    {
        return "orders";
    }

    public function parseForm($form)
    {
        $this->id = $form['id'];
        $this->name = $form['name'];
        $this->phone = $form['phone'];
        $this->homePhone = $form['home_phone'];
        $this->arrivalDay = $form['arrival_day'];
        $this->arrivalTime = $form['arrival_time'];
        $this->materials = $form['materials'];
        $this->operatorId = $form['operator_id'];
        $this->statusId = $form['status_id'];
        $this->metro = $form['metro'];
        $this->area = $form['area'];
        $this->adress = $form['adress'];
        $this->problem = $form['problem'];
        $this->orderCreate = time() + 10800;
        $this->masterId = $form['master_id'];
        $this->performanceStatusId = $form['performance_status_id'];
        $this->paymentStatus = $form['payment_status'];
        $this->report = $form['report'];
        $this->reportDate = $form['report_date'];

        return $this;
    }

    public function toString()
    {
        return "'$this->id', 
                '$this->name',
                '$this->phone',
                '$this->arrivalDay',
                '$this->arrivalTime',
                '$this->materials',
                '$this->operatorId',
                '$this->statusId',
                '$this->area',
                '$this->adress',
                '$this->problem',
                '$this->orderCreate',
                '$this->masterId',
                '$this->performanceStatusId',
                '$this->paymentStatus',
                '$this->report',
                '$this->reportDate'"
            ;
    }
}
