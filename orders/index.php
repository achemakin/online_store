<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

if (isAdmin() || isOperator()) {
    showHeader($adminMenu);
} else {
    goToAdmin();
}

$orders = getOrders();
?>

<main class="page-order">
    <h1 class="h h--1"><?=getTitleArrayThroughPath($adminMenu)?></h1>    
    
    <?php 
    /* Сортировка заказов по признаку выполнены или не выполнены */
    $statusCol  = array_column($orders, 'status');
    $dateCol = array_column($orders, 'date');
    array_multisort($statusCol, SORT_ASC, $dateCol, SORT_DESC, $orders);

    renderTemplates($orders, 'orderList');
    ?>
    
</main>

<?php
showFooter($userMenu);
?>
