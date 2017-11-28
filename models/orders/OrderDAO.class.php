<?php

class OrderDAO
{
    public $id;
    public $name;
    public $phone;
    public $arrivalDate;
    public $arrivalTime;
    public $materials;
    public $operatorId;
    public $statusId;
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
        $this->arrivalDate = $form['arrival_date'];
        $this->arrivalTime = $form['arrival_time'];
        $this->materials = $form['materials'];
        $this->operatorId = $form['operator_id'];
        $this->statusId = $form['status_id'];
        $this->area = $form['area'];
        $this->adress = $form['adress'];
        $this->problem = $form['problem'];
        $this->orderCreate = $form['order_create'];
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
                '$this->arrivalDate',
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
