<?php

class Enum
{
    const ROLES = array(
        1 => 'Мастер',
        2 => 'Оператор',
        3 => 'HR',
        4 => 'Администратор'
    ),


        ORDER_STATUS = array(
            0 => '<span class="label label-default">Не распределен</span>',
            1 => '<span class="label label-danger">Прозвон</span>',
            2 => '<span class="label label-primary">Подтвержден</span>',
            3 => '<span class="label label-primary">В работе</span>',
            4 => '<span class="label label-info">Прибыл на заказ</span>',
            5 => '<span class="label label-success">Заказ выполнен</span>'
    ),

        MASTER_ORDER_STATUS = array(
        0 => 'в работе',
        1 => 'вызов потдвержден',
        2 => 'прибыл на заказ',
        3 => 'заказ выполнен',
        4 => 'прозвон',
        5 => 'отказ',
        6 => 'перенос',
        7 => 'ремонт',
        8 => 'повтор',
        9 => 'ремонт',
    ),

        /*
         * Ожидает оплаты
         *
         *
         */

        ORDER_PAYMENT_STATUS = array(
            0 => 'Не оплачен',
            1 => 'В ожидании оплаты',
            2 => 'Оплачен',
    );
}
