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

    ORDER_PAYMENT_STATUS = array(
        0 => 'Не оплачен',
        1 => 'В ожидании оплаты',
        2 => 'Оплачен',
    );
}
