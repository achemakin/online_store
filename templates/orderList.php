<ul class="page-order__list">
    <?php
    
    /* Сортировка заказов по признаку выполнены или не выполнены */
    $statusCol  = array_column($var, 'status');
    array_multisort($statusCol, SORT_ASC, $var);

    /* Вывод списка заказов на страницу */
    foreach ($var as $order): ?>

    <li class="order-item page-order__item">
        <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--id">
                <span class="order-item__title">Номер заказа</span>
                
                <span class="order-item__info order-item__info--id"><?=$order['id']?></span>
            </div>
            
            <div class="order-item__group">
                <span class="order-item__title">Сумма заказа</span><?=$order['cost']?> руб.
            </div>
            
            <button class="order-item__toggle"></button>
        </div>
    
        <div class="order-item__wrapper">
            <div class="order-item__group order-item__group--margin">
                <span class="order-item__title">Заказчик</span>
                
                <span class="order-item__info"><?=$order['surname'] . ' ' . $order['name'] . ' ' . $order['thirdName']?></span>
            </div>
            
            <div class="order-item__group">
                <span class="order-item__title">Номер телефона</span>
                
                <span class="order-item__info"><?=$order['phone']?></span>
            </div>
            
            <div class="order-item__group">
                <span class="order-item__title">Способ доставки</span>
                
                <span class="order-item__info"><?=$order['delivery'] == 0 ? 'Самовывоз' : 'Курьерная доставка'?></span>
            </div>
            
            <div class="order-item__group">
                <span class="order-item__title">Способ оплаты</span>
                
                <span class="order-item__info"><?=$order['pay'] == 'cash' ? 'Наличные' : 'Банковская карта'?></span>
            </div>
            
            <div class="order-item__group order-item__group--status">
                <span class="order-item__title">Статус заказа</span>
                
                <span class="order-item__info order-item__info--<?=$order['status'] == '0' ? 'no' : 'yes'?>"><?=$order['status'] == '0' ? 'Не выполнено' : 'Выполнено'?></span>
                
                <button class="order-item__btn">Изменить</button>
            </div>
        </div>
        
        <div class="order-item__wrapper">
            <div class="order-item__group">
                <span class="order-item__title">Адрес доставки</span>
                
                <span class="order-item__info"><?= !empty($order['city']) ? 'г. ' . $order['city'] . ', ул. ' . $order['street'] . ', д. ' . $order['home'] . ', кв. ' . $order['aprt'] : ''?></span>
            </div>
        </div>
        
        <div class="order-item__wrapper">
            <div class="order-item__group">
                <span class="order-item__title">Комментарий к заказу</span>
                
                <span class="order-item__info"><?=$order['comment']?></span>
            </div>
        </div>
    </li>

    <?php endforeach; ?>

</ul>