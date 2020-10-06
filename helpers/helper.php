<?php 

/**
 * Функция подключает Header
 * @param array $menuList передаются различные меню ($userMenu, $adminMenu)
 */
function showHeader($menuList) {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
}

/**
 * Функция подключает Footer
 * @param array $menuList передаются различные меню ($userMenu, $adminMenu)
 */
function showFooter($menuList) {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
}

/**
 * Функция выводит пункты меню
 * @param array $array массив неодбходимых значений
 * @param string $classUl наименование класса для меню
 */
function showMenu (array $array, string $classUl)
{    
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/main_menu.php';
}

/** Функция получает текущий номер страницы
 * @return int текущий номер страницы
 */
function getPageNumber(): int
{
    return isset($_GET['page']) ? $_GET['page'] - 1 : 0;
}

/**
 * Функция выводит шаблоны
 * @param $var - переменная передаваемая в шаблон
 * @param $template - наименование шаблона
 */
function renderTemplates($var, $template) {    
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/' . $template . '.php';
}

/** 
 * Функция возвращает true или false в зависимости от того является ли переданный url текущим
 * @param string $url url который необходимо проверить текущий или нет
 * @return bool либо true либо false
 */
function isCurrentUrl($url){
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $url;
}

/**
 * Функция возвращает текст заголовка исходя из текущего Path
 * @param array $array массив неодбходимых значений
 * @return string $item['title'] текст заголовка исходя из текущего Path
 */
function getTitleArrayThroughPath(array $array) 
{
    foreach ($array as $item) {
        if (isCurrentUrl($item['path'])) {
            return $item['namePage'];
        }
    }

    return 'Страница отсутствует.';
}

/**
 * Функция для проверки авторизации пользователя
 * @param bool $isRedirectToMain - нужно-ли вызывать goToMain()
 * @return bool $auth - пользователь авторизован или не авторизован
 */
function isAuth(bool $isRedirectToMain = false): bool 
{    
    $auth = isset($_SESSION['auth']) && $_SESSION['auth'] == true;
    
    if(!$auth && $isRedirectToMain){
        goToAdmin();
    }
    
    return $auth;
}

/**
 * Функция для проверки является ли пользователь администратором
 * @param bool $isRedirectToMain - нужно-ли вызывать goToMain()
 * @return bool $admin - пользователь является администратором или нет
 */
function isAdmin(bool $isRedirectToMain = false): bool 
{    
    $admin = isset($_SESSION['auth']) && $_SESSION['admin'] == true;
    
    if(!$admin && $isRedirectToMain){
        goToAdmin();
    }
    
    return $admin;
}

/**
 * Функция для проверки является ли пользователь оператором
 * @param bool $isRedirectToMain - нужно-ли вызывать goToMain()
 * @return bool $admin - пользователь является оператором или нет
 */
function isOperator(bool $isRedirectToMain = false): bool
{    
    $operator = isset($_SESSION['auth']) && $_SESSION['operator'] == true;
    
    if(!$operator && $isRedirectToMain){
        goToAdmin();
    }
    
    return $operator;
}

/**
 * Функция для перехода на страницу авторизации 
 */
function goToAdmin() {
    header('Location: /admin/');
}

/**
 * Функция фильтрации и проверки данных, полученных от пользователя
 * @param string $inputText данные, которые необходимо проверить
 * @return string проверенные данные
 */
function filterInputText(string $inputText): string
{
    $inputText = strip_tags($inputText);
    $inputText = htmlspecialchars($inputText);   

    return $inputText;
}

/**
 * Функция склонения числительных
 * @param int $number числительное
 * @param array $titles список слов со склонениями
 * @return string слово с необходимым склонением 
 */
function declOfNum(int $number, array $titles): string
{
    $cases = [2, 0, 1, 1, 1, 2];
    return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[($number % 10 < 5) ? $number % 10 : 5]];
}

/**
 * Фильтрует товары в соответствии с GET запросом и возвращает отфильтрованные товары
 * @param array $products массив продуктов, которые нужно отфильтровать
 * @return array отфильтрованные продукты  
 */
function productsFilter($products) {
    if (isset($_GET['sale'])) {
        $productsNew = [];

        foreach ($products as $product) {
            if ($product['sale'] == '1') {
                $productsNew[] = $product;
            }
        }

        $products = $productsNew;
    }

    if (isset($_GET['new'])) {
        $productsNew = [];

        foreach ($products as $product) {
            if ($product['novelty'] == '1') {
                $productsNew[] = $product;
            }
        }

        $products = $productsNew;
    }

    if (isset($_GET['minPrice'])) {
        $productsNew = [];

        foreach ($products as $product) {
            if ($product['price'] >= $_GET['minPrice'] && $product['price'] <= $_GET['maxPrice']) {
                $productsNew[] = $product;
            }
        }

        $products = $productsNew;
    }

    $_SESSION['productsFilter'] = $products;

    return $products;
}
