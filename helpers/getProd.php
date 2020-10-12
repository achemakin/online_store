<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

/* Получить список продуктов */
$products = $_SESSION['productsFilter'];

/* Получить порядковый номер товара с которого начинается страница */
$startProductNumber = $_SESSION['startProductNumber'];

/* Получить порядковый номер товара на котором заканчивается страница */
$endProductNumber = $_SESSION['endProductNumber'];

/* Сортировка списка продуктов */
if (!empty($_GET['flag'])) {
    $_SESSION['sort']['flag'] = $_GET['flag'];
}

if (!empty($_GET['order'])) {
    $_SESSION['sort']['order'] = $_GET['order'];
}

if (isset($_SESSION['sort'])) {
    $flag = isset($_SESSION['sort']['flag']) ? $_SESSION['sort']['flag'] : 'id';
    $flagCol  = array_column($products, $flag);

    $order = isset($_SESSION['sort']['order']) && $_SESSION['sort']['order'] == 'SORT_DESC' ? SORT_DESC : SORT_ASC;

    array_multisort($flagCol, $order, $products);
}

/* Вывод страницы */
$productsPage = array_slice($products, $startProductNumber, $endProductNumber - $startProductNumber);
echo json_encode($productsPage);