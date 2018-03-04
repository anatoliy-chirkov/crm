<?php

interface IGetOrder
{
    public function get();

    public function getById($id);

    public function getByCustomerPhone($phone);

    public function getByDoerId($id);

    public function getByDateInterval($dateAfter, $dateBefore);

    public function getByDateBefore($date);

    public function getByDateAfter($date);
}
