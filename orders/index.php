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
    
    <?=renderTemplates($orders, 'orderList')?>
</main>

<?php
showFooter($userMenu);
?>
