<?php

class Enum
{
    const

        ROLES = array(
        1 => 'Мастер',
        2 => 'Оператор',
        3 => 'HR',
        4 => 'Администратор'
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
        8 => 'повтор'
    ),

        GRAPHIC_ORDER_STATUS = array(
        0 => '<span class="label label-primary">В работе</span>',
        1 => '<span class="label label-info">Вызов потдвержден</span>',
        2 => '<span class="label label-info">Прибыл на заказ</span>',
        3 => '<span class="label label-success">Заказ выполнен</span>',
        4 => '<span class="label label-danger">Прозвон</span>',
        5 => '<span class="label label-danger">Отказ</span>',
        6 => '<span class="label label-default">Перенос</span>',
        7 => '<span class="label label-warning">Ремонт</span>',
        8 => '<span class="label label-default">Повтор</span>'
    ),

        GRAPHIC_PAYMENT_STATUS = array(
        0 => '<span class="label label-warning">Ожидание оплаты</span>',
        1 => '<span class="label label-success">Оплачен</span>'
    );
}
