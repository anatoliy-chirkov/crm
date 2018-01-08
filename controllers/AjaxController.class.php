<?php

class AjaxController
{
    public function getFinalReportFields()
    {
        $statusId = $_POST['status_id'];

        if ($statusId == 3) {
            echo
                '<div class="form-group">
                    <label for="input3" class=" control-label">Сумма заказа (руб.)</label>
                    <input name="order_amount" type="number" class="form-control" id="input3">
                </div>
                <div class="form-group">
                    <label for="input4" class=" control-label">Расходы (руб.)</label>
                    <input name="expenses_amount" type="number" class="form-control" id="input4">
                </div>';
        } elseif ($statusId == 6 || $statusId == 7) {
            echo
                '<div class="form-group">
                    <label for="input6" class=" control-label">Следующая дата прибытия</label>
                    <input name="arrival_day" type="date" class="form-control" id="input6">
                </div>
                <div class="form-group">
                    <label for="input6" class=" control-label">Время прибытия</label>
                    <input name="arrival_time" type="time" class="form-control" id="input6">
                </div>';
        }
    }
}
