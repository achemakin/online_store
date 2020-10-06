<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

isAdmin(true);

$showFormPage = true;

if (isset($_GET['id'])) {    
    $productsList = getProducts();
    $showFormPage = false;    
    
    foreach ($productsList as $item) {
        if ($item['id'] == $_GET['id']) {
            $product = $item;
            
            foreach ($product['categories'] as $category) {
                $prodCategories[] = $category['value'];
            }            
            
            $showFormPage = true;
        }
    }    
}

showHeader($adminMenu);

$categoriesList = getCategories();
?>

<main class="page-add">
    <h1 class="h h--1"><?= isset($_GET['id']) ? 'Изменение товара': 'Добавление товара'?></h1>

    <?php
    if ($showFormPage): ?>
        <form id="formAddProduct" class="custom-form" action="/add/addProduct.php" enctype="multipart/form-data" method="post">
            <?= isset($_GET['id']) ? '<input type="text" name="id" value="' . $_GET["id"] . '" hidden>' : ''?> 
            
            <fieldset class="page-add__group custom-form__group">
                <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
                
                <label for="product-name" class="custom-form__input-wrapper page-add__first-wrapper">
                    <input type="text" class="custom-form__input" name="name" value="<?= isset($_GET['id']) ? $product['name'] : ''?>"  id="product-name" required
    >
                    
                    <p class="custom-form__input-label">
                        <?= isset($_GET['id']) ? '' : 'Название товара'?>
                    </p>
                </label>
                
                <label for="product-price" class="custom-form__input-wrapper">
                    <input type="text" 
                        class="custom-form__input" 
                        name="price" 
                        value="<?= isset($_GET['id']) ? $product['price'] : ''?>" 
                        id="product-price"                        
                        pattern="^[ 0-9]+$" 
                        required
                    >
                    
                    <p class="custom-form__input-label">
                        <?= isset($_GET['id']) ? '' : 'Цена товара'?>          
                    </p>
                </label>
            </fieldset>
            
            <fieldset class="page-add__group custom-form__group">
                <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
                
                <ul class="add-list">
                    <li class="add-list__item add-list__item--add">
                        <input type="file" name="photo" id="product-photo" hidden="">

                        <label for="product-photo">Добавить фотографию</label>
                    </li>

                    <?php if (isset($_GET['id']) && !empty($product['img'])): ?>
                        <li class="add-list__item add-list__item--active js-changeImg">
                            <img src="/img/products/<?=$product['img']?>">
                        </li>            
                    <?php endif;?>
                </ul>
            </fieldset>
            
            <fieldset class="page-add__group custom-form__group">
                <legend class="page-add__small-title custom-form__title">Раздел</legend>
                
                <div class="page-add__select">
                    <select name="categories[]" class="custom-form__select" multiple="multiple">
                        <option hidden="">Название раздела</option>
                        <?php
                        foreach ($categoriesList as $category):?>
                            <option 
                                value="<?=$category['id']?>"
                                <?= isset($_GET['id']) && !empty($prodCategories) && in_array($category['value'], $prodCategories) ? 'selected' : ''?>
                            ><?=$category['title']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <input type="checkbox" name="novelty" id="new" class="custom-form__checkbox" <?= isset($_GET['id']) && $product['novelty'] ? 'checked': ''?>>
                <label for="new" class="custom-form__checkbox-label" >Новинка</label>
                
                <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= isset($_GET['id']) && $product['sale'] ? 'checked': ''?>>
                <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
            </fieldset>
            
            <button class="button" type="submit"><?= isset($_GET['id']) ? 'Изменить товар': 'Добавить товар'?></button>
        </form>
        
        <section class="shop-page__popup-end page-add__popup-end" hidden="">
            <div class="shop-page__wrapper shop-page__wrapper--popup-end">
                <h2 class="h h--1 h--icon shop-page__end-title"><?= isset($_GET['id']) ? 'Товар успешно изменен' : 'Товар успешно добавлен'?></h2>
            </div>
        </section>

    <?php else: ?>

        <section class="shop-page__popup-end page-add__popup-end">
            <div class="shop-page__wrapper shop-page__wrapper--popup-end">
                <h2 class="h h--1 h--icon shop-page__end-title">Товар с ID = <?=$_GET['id']?> отсутствует в базе данных</h2>
            </div>
        </section>
        
    <?php endif; ?>
</main>

<?php
showFooter($userMenu);
?>
