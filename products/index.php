<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

isAdmin(true);

$productsList = getProducts();

showHeader($adminMenu);
?>

<main class="page-products">
    <h1 class="h h--1"><?=getTitleArrayThroughPath($adminMenu)?></h1>
    
    <a class="page-products__button button" href="/add/">Добавить товар</a>
    
    <div class="page-products__header">
        <span class="page-products__header-field">Название товара</span>
        <span class="page-products__header-field">ID</span>
        <span class="page-products__header-field">Цена</span>
        <span class="page-products__header-field">Категория</span>
        <span class="page-products__header-field">Новинка</span>
    </div>
    
    <ul class="page-products__list">
        <?php 
            foreach ($productsList as $product) {
                $prodCategories = '';

                foreach ($product['categories'] as $category) {
                    $prodCategories .= $category['title'] . '<br/>'; 
                }
                
            ?>
            <li class="product-item page-products__item">
                <b class="product-item__name"><?=$product['name']?></b>
                
                <span class="product-item__field js-productId"><?=$product['id']?></span>
                
                <span class="product-item__field"><?=$product['price']?> руб.</span>
                               
                <span class="product-item__field"><?=$prodCategories?></span>

                <span class="product-item__field"><?=$product['novelty'] == '1' ? 'Да' : 'Нет'?></span>
                
                <a href="/add/?id=<?=$product['id']?>" class="product-item__edit" aria-label="Редактировать"></a>
                
                <button class="product-item__delete"></button>
            </li>
            <?php } ?>        
    </ul>
</main>

<?php
showFooter($userMenu);
?>
