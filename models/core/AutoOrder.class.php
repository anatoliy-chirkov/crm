<?php

class AutoOrder extends OrderORM implements IGetOrder
{
    public function get()
    {
        return $this->select()->execute();
    }

    public function getById($id)
    {
        return $this->select()->where('id', $id)->execute();
    }

    public function getByCustomerPhone($phone)
    {
        return $this->select()->where('customer_phone', $phone)->execute();
    }

    public function getByDoerId($id)
    {
        return $this->select()->where('doer_id', $id)->execute();
    }

    public function getByDateInterval($dateAfter, $dateBefore)
    {
        return $this->select()->whereInterval('created_at', $dateAfter, $dateBefore)->execute();
    }

    public function getByDateBefore($date)
    {
        return $this->select()->whereLess('created_at', $date)->execute();
    }

    public function getByDateAfter($date)
    {
        return $this->select()->whereMore('created_at', $date)->execute();
    }
}
