<?php

class OrderStatus
{
    /**
     * @return OrderStatus
     */
    public static function me()
    {
        return new self;
    }

    /**
     * @param $row
     * @return string
     */
    public function getActionsForStatus($row)
    {
        $orderId = $row['id'];
        $statusId = $row['status_id'];

        if ($statusId == 0 || $statusId == 7) {
            return
                '<div class="call_confirmed-button">'.
                '<a href="#" class="btn btn-primary btn-sm">Вызов подтвержден</a>'.
                '<br>'.
                '<a href="/orders/card?id='.$orderId.'&page=report" class="btn btn-primary btn-sm">Отчет</a>'.
                '</div>'.
                '<div class="call_confirmed-input hidden">'.
                '</form><form id="status'.$orderId.'" action="/orderStatusSetter/setStatus?id=1&order_id='.$orderId.'" role="form" method="POST">'.
                '<div class="form-group">'.
                '<label for="input6" class=" control-label">Время прибытия</label>'.
                '<input form="status'.$orderId.'" name="approve_arrival_time" type="time" class="form-control" id="input6">'.
                '</div>'.
                '<div class="form-group">'.
                '<button form="status'.$orderId.'" type="submit" class="btn btn-primary">Подтвердить</button>'.
                '</div></form></div>';
        } else if ($statusId == 1) {
            return
                '<a href="/orderStatusSetter/setStatus?id=2&order_id='.$orderId.'" class="btn btn-primary btn-sm">Прибыл на заказ</a>'.
                '<br>'.
                '<a href="/orders/card?id='.$orderId.'&page=report" class="btn btn-primary btn-sm">Отчет</a>';
        } else if ($statusId == 2) {
            return
                '<a href="/orders/card?id='.$orderId.'&page=report" class="btn btn-primary btn-sm">Заказ выполнен</a>';
        } else if ($statusId == 6 ||  $statusId == 8) {
            return
                '<a href="/orderStatusSetter/setStatus?id=0&order_id='.$orderId.'" class="btn btn-primary btn-sm">Принять в работу</a>'.
                '<br>'.
                '<a href="/orders/card?id='.$orderId.'&page=report" class="btn btn-primary btn-sm">Отчет</a>';
        } else {
            //3, 4, 5,
            return '-';
        }
    }
}
