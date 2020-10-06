<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

showHeader($userMenu);

/* список товаров c фильтром Новинки */
$productsList = [];

foreach (getProducts() as $product) {
    if ($product['novelty'] == 1) {
        $productsList[] = $product;
    }
}

/* Стартовая сортировка товаров */
$isSortFlag = isset($_SESSION['sort']) ? $_SESSION['sort']['flag'] : '';
$isSortOrder = isset($_SESSION['sort']) ? $_SESSION['sort']['order'] : '';

/* Получение минимально и максимальной возможной цены товара для отображения на странице */
$minMax = array_column($productsList, 'price');
$minProd = min($minMax);
$maxProd = max($minMax);

/* Фильтрация товаров */
$productsList = productsFilter($productsList);

/* Список категорий */
$categoriesList = getCategories();

/* количество страниц (кнопок пагинации) */
$shopPaginator = ceil(count($productsList) / $numberProductsPage);

/* номер товара с которого начинается текущая страница  */
$startProductNumber = getPageNumber() <= $shopPaginator ? getPageNumber() * $numberProductsPage : 0;

$_SESSION['startProductNumber'] = $startProductNumber;

/* номер товара на котором заканчивается текущая страница  */
if (intdiv(count($productsList)-$startProductNumber, $numberProductsPage) != 0) {
    $endProductNumber = $startProductNumber + $numberProductsPage;
} else {
    $endProductNumber = count($productsList);
}

$_SESSION['endProductNumber'] = $endProductNumber;
?>

<main class="shop-page">
    <header class="intro">
        <div class="intro__wrapper">
            <h1 class=" intro__title">COATS</h1>
            <p class="intro__info">Collection 2018</p>
        </div>
    </header>
    
    <section class="shop container">
        <section class="shop__filter filter">
            <form id="formFilterProduct" action="/" enctype="multipart/form-data" method="GET">
                <div class="filter__wrapper">
                    <b class="filter__title">Категории</b>
                    <ul class="filter__list">
                        <li>
                            <a  class="<?= !isset($_GET['category']) ? 'filter__list-item active' : 'filter__list-item'?>"
                                href="<?=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . 
                                    (isset($_GET['minPrice']) || isset($_GET['maxPrice']) || isset($_GET['new']) || isset($_GET['sale']) ? '?' : '') .
                                    (isset($_GET['minPrice']) ? ('minPrice=' . $_GET['minPrice']) : '') .
                                    (isset($_GET['maxPrice']) ? ('&maxPrice=' . $_GET['maxPrice']) : '') .
                                    (isset($_GET['new']) ? ('&new=' . $_GET['new']) : '') .
                                    (isset($_GET['sale']) ? ('&sale=' . $_GET['sale']) : '')
                                ?>"> Все
                            </a>
                        </li>

                        <?php
                        foreach ($categoriesList as $category):?>                   
                        <li>
                            <a  class="<?= isset($_GET['category']) && $_GET['category'] == $category['value'] ? 'filter__list-item active' : 'filter__list-item'?>"
                                href="<?=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)?>?category=<?=$category['value'] .
                                    (isset($_GET['minPrice']) ? ('&minPrice=' . $_GET['minPrice']) : '') .
                                    (isset($_GET['maxPrice']) ? ('&maxPrice=' . $_GET['maxPrice']) : '') .
                                    (isset($_GET['new']) ? ('&new=' . $_GET['new']) : '') .
                                    (isset($_GET['sale']) ? ('&sale=' . $_GET['sale']) : '')
                                ?>"> <?=$category['title']?>
                            </a>
                        </li>
                        <?php endforeach; ?>                                           
                    </ul>

                    <input type="hidden" <?= isset($_GET['category'])  ? 'name="category" value=' . $_GET['category'] : '' ?>>
                </div>

                <div class="filter__wrapper">
                    <b class="filter__title">Фильтры</b>
                    
                    <div class="filter__range range">
                        <span class="range__info">Цена</span>
                        
                        <div class="range__line" aria-label="Range Line"></div>
                        
                        <div class="range__res">
                            <span class="range__res-item min-price" min=<?=$minProd?>><?= isset($_GET['minPrice']) ? $_GET['minPrice'] : $minProd?> руб.</span>
                            <input class="js-min-price" type="hidden" name="minPrice" value="<?= isset($_GET['minPrice']) ? $_GET['minPrice'] : $minProd?>">
                            
                            <span class="range__res-item max-price" max=<?=$maxProd?>><?= isset($_GET['maxPrice']) ? $_GET['maxPrice'] : $maxProd?> руб.</span>
                            <input class="js-max-price" type="hidden" name="maxPrice" value="<?= isset($_GET['maxPrice']) ? $_GET['maxPrice'] : $maxProd?>">
                        </div>
                    </div>
                </div>

                <fieldset class="custom-form__group">
                    <input type="hidden" name="new" value="on">
                    
                    <input type="checkbox" name="sale" id="sale" class="custom-form__checkbox" <?= isset($_GET['sale']) ? 'checked' : ''?>>
                    <label for="sale" class="custom-form__checkbox-label custom-form__info" style="display: block;">Распродажа</label>
                </fieldset>

                <button class="button" type="submit" style="width: 100%">Применить</button>
            </form>
        </section>

        <div class="shop__wrapper">
            <section class="shop__sorting">
                <div class="shop__sorting-item custom-form__select-wrapper">
                    <select class="custom-form__select js-sort-flag" name="sortFlag">
                        <option value="0" hidden="">Сортировка</option>
                        <option value="price" <?= $isSortFlag == 'price' ? 'selected' : '' ?>>По цене</option>
                        <option value="name" <?= $isSortFlag == 'name' ? 'selected' : '' ?>>По названию</option>
                    </select>
                </div>

                <div class="shop__sorting-item custom-form__select-wrapper">
                    <select class="custom-form__select js-sort-order" name="sortOrder">
                        <option value="0" hidden="">Порядок</option>
                        <option value="SORT_ASC" <?= $isSortOrder == 'SORT_ASC' ? 'selected' : '' ?>>По возрастанию</option>
                        <option value="SORT_DESC" <?= $isSortOrder == 'SORT_DESC' ? 'selected' : '' ?>>По убыванию</option>
                    </select>
                </div>
                
                <p class="shop__sorting-res">Найдено <span class="res-sort"><?=count($productsList)?></span> <?=declOfNum(count($productsList), ['модель', 'модели', 'моделей'])?></p>
            </section>
            
            <section class="shop__list">
                <?php if (count($productsList) == 0): ?>
                    <p>Нет товаров с выбранными параметрами</p>
                <?php endif; ?>
            </section>

            <ul class="shop__paginator paginator">
                <?php
                    /* Вывод кнопок пагинации */
                    for ($i = 0; $i < $shopPaginator; $i++) {
                        renderTemplates($i, 'shopPaginator');
                    } 
                ?>
            </ul>
        </div>
    </section>

    <section class="shop-page__order" hidden="">
        <div class="shop-page__wrapper">
            <h2 class="h h--1">Оформление заказа</h2>
            
            <form id="formOrder" action="#" method="post" class="custom-form js-order" enctype="multipart/form-data">
                <fieldset class="custom-form__group">
                    <input type="hidden" name="prodId" value="">
                    
                    <legend class="custom-form__title">Укажите свои личные данные</legend>
                    
                    <p class="custom-form__info">
                        <span class="req">*</span> поля обязательные для заполнения
                    </p>
                    
                    <div class="custom-form__column">
                        <label class="custom-form__input-wrapper" for="surname">
                            <input id="surname" class="custom-form__input" type="text" name="surname" required>
                            
                            <p class="custom-form__input-label">Фамилия 
                                <span class="req">*</span>
                            </p>
                        </label>
                        
                        <label class="custom-form__input-wrapper" for="name">
                            <input id="name" class="custom-form__input" type="text" name="name" required>
                            
                            <p class="custom-form__input-label">Имя 
                                <span class="req">*</span>
                            </p>
                        </label>
                        
                        <label class="custom-form__input-wrapper" for="thirdName">
                            <input id="thirdName" class="custom-form__input" type="text" name="thirdName">
                            
                            <p class="custom-form__input-label">Отчество</p>
                        </label>
                        
                        <label class="custom-form__input-wrapper" for="phone">
                            <input id="phone" class="custom-form__input" type="tel" name="phone" required>
                            
                            <p class="custom-form__input-label">Телефон 
                                <span class="req">*</span>
                            </p>
                        </label>
                        
                        <label class="custom-form__input-wrapper" for="email">
                            <input id="email" class="custom-form__input" type="email" name="email" required>
                            
                            <p class="custom-form__input-label">Почта 
                                <span class="req">*</span>
                            </p>
                        </label>
                    </div>
                </fieldset>
                
                <fieldset class="custom-form__group js-radio">
                    <legend class="custom-form__title custom-form__title--radio">Способ доставки</legend>
                    
                    <input id="dev-no" class="custom-form__radio" type="radio" name="delivery" value="0" checked="">
                    
                    <label for="dev-no" class="custom-form__radio-label">Самовывоз</label>
                    
                    <input id="dev-yes" class="custom-form__radio" type="radio" name="delivery" value="1">
                    
                    <label for="dev-yes" class="custom-form__radio-label">Курьерная доставка</label>
                </fieldset>
                
                <div class="shop-page__delivery shop-page__delivery--no">
                    <table class="custom-table">
                        <caption class="custom-table__title">Пункт самовывоза</caption>
                        
                        <tr>
                            <td class="custom-table__head">Адрес:</td>
                            <td>Москва г, Тверская ул,<br> 4 Метро «Охотный ряд»</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Время работы:</td>
                            <td>пн-вс 09:00-22:00</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Оплата:</td>
                            <td>Наличными или банковской картой</td>
                        </tr>
                        <tr>
                            <td class="custom-table__head">Срок доставки: </td>
                            <td class="date">13 декабря—15 декабря</td>
                        </tr>
                    </table>
                </div>
                
                <div class="shop-page__delivery shop-page__delivery--yes" hidden="">
                    <fieldset class="custom-form__group">
                        <legend class="custom-form__title">Адрес</legend>
                        
                        <p class="custom-form__info">
                            <span class="req">*</span> поля обязательные для заполнения
                        </p>
                        <div class="custom-form__row">
                            <label class="custom-form__input-wrapper" for="city">
                                <input id="city" class="custom-form__input" type="text" name="city">
                                
                                <p class="custom-form__input-label">Город <span class="req">*</span></p>
                            </label>
                            
                            <label class="custom-form__input-wrapper" for="street">
                                <input id="street" class="custom-form__input" type="text" name="street">
                                
                                <p class="custom-form__input-label">Улица <span class="req">*</span></p>
                            </label>
                            
                            <label class="custom-form__input-wrapper" for="home">
                                <input id="home" class="custom-form__input custom-form__input--small" type="text" name="home">
                                
                                <p class="custom-form__input-label">Дом <span class="req">*</span></p>
                            </label>
                            
                            <label class="custom-form__input-wrapper" for="aprt">
                                <input id="aprt" class="custom-form__input custom-form__input--small" type="text" name="aprt">
                                
                                <p class="custom-form__input-label">Квартира <span class="req">*</span></p>
                            </label>
                        </div>
                    </fieldset>
                </div>

                <fieldset class="custom-form__group shop-page__pay">
                    <legend class="custom-form__title custom-form__title--radio">Способ оплаты</legend>
                    
                    <input id="cash" class="custom-form__radio" type="radio" name="pay" value="cash">
                    <label for="cash" class="custom-form__radio-label">Наличные</label>
                    
                    <input id="card" class="custom-form__radio" type="radio" name="pay" value="card" checked="">
                    <label for="card" class="custom-form__radio-label">Банковской картой</label>
                </fieldset>
                
                <fieldset class="custom-form__group shop-page__comment">
                    <legend class="custom-form__title custom-form__title--comment">Комментарии к заказу</legend>
                    
                    <textarea class="custom-form__textarea" name="comment"></textarea>
                </fieldset>
                
                <button class="button" type="submit">Отправить заказ</button>
            </form>
        </div>
    </section>

    <section class="shop-page__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Спасибо за заказ!</h2>
            
            <p class="shop-page__end-message">Ваш заказ успешно оформлен, с вами свяжутся в ближайшее время</p>
            
            <button class="button">Продолжить покупки</button>
        </div>
    </section>
</main>

<?php
showFooter($userMenu);
?>
