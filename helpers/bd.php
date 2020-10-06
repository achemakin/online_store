<?php

/**
 * Функция подключения к базе данных
 * @return object информация о соединении
 */
function getConnection() : object 
{
    $bdHost = 'localhost';
    $bdLogin = 'root';
    $bdPassword = 'root';
    $bdName = 'prod';
    
    static $bd;

    if (empty($bd)) {
        $bd = mysqli_connect($bdHost, $bdLogin, $bdPassword, $bdName);
        
        if (!$bd) {
            echo mysqli_connect_error();
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit();
        }    
    } 

    return $bd;
}

/**
 * Функция получает данные пользователя из БД
 * @param string $email электронная почта пользователя
 * @return array данные пользователя
 */
function getUserByEmail(string $email) : array
{
    $email = mysqli_real_escape_string(getConnection(), $email);
        
    $result = mysqli_query(getConnection(), "
        SELECT `u`.*, `gu`.`groups_id`, `g`.`title`  
        FROM `users` AS `u` 
        LEFT JOIN `groups_users` AS `gu` ON `u`.`id` = `users_id` 
        LEFT JOIN `groups` AS `g` ON `g`.`id` = `groups_id` 
        WHERE `email` = '$email'
    ");

    if (mysqli_num_rows($result) != 0) {
        $getUser =  mysqli_fetch_assoc($result);
        $groupsId = [];

        foreach($result as $row) {              
            $getUser['groups'][] = $row['title'];
            $getUser['groupsId'][] = $row['groups_id'];
        }
    } else {        
        $getUser = [];
    }

    return $getUser;
}

/**
 * Получает либо все товаровы из БД либо в зависимости от выбранной категории 
 * @return array список товаров
 */
function getProducts() : array
{
    /* не выбрана категория и не выбрана страница */
    if (!isset($_GET['category']) && !isset($_GET['page'])) {
        unset($_SESSION['products']);
    }
    
    /* выбрана категория и не выбрана страница */
    if (isset($_GET['category']) && !isset($_GET['page'])) {
        $id = 1;
        foreach (getCategories() as $item) {
            if ($item['value'] == $_GET['category']) {
                $id = $item['id'];
            } 
        }        
                       
        $id = mysqli_real_escape_string(getConnection(), $id);

        $result = mysqli_query(getConnection(), "
            SELECT `p`.* 
            FROM `products` AS `p`, `products_categories` AS `pc`
            WHERE `p`.`id` = `pc`.`products_id` AND `pc`.`categories_id` = '$id' AND `p`.`active` = 1        
        ");
                
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } 
    
    /* не сохранен список продуктов и не выбрана категория */
    if (!isset($_SESSION['products']) && !isset($_GET['category'])) {
        $result = mysqli_query(getConnection(), "SELECT * FROM `products` WHERE `active` = 1");
        
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    if (!empty($products)) {
        foreach ($products as $key => $product) {
            $id = $product['id'];
            $result = mysqli_query(getConnection(), "
                SELECT `c`.* 
                FROM `categories` AS `c`, `products_categories`
                WHERE `products_id` = '$id' AND `categories_id` = `id`    
            ");
            
            $products[$key]['categories'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        
        $_SESSION['products'] = $products;
    }
    
    return $_SESSION['products'];
}

/**
 * Функция получает данные всех категорий из БД
 * @return array список категори
 */
function getCategories() : array
{
    $result = mysqli_query(getConnection(), "
        SELECT * FROM `categories`
    ");

    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
}

/**
 * Функция меняет признак active в products c true на false
 * @param int $id - id сообщения
 */
function isActiveUpdate(int $id) {
    $id = mysqli_real_escape_string(getConnection(), $id);
    
    mysqli_query(getConnection(), "UPDATE `products` SET `active` = '0' WHERE `id` = '$id'");
}

/**
 * Функция добавляет товар в БД 
 */
function isAddProduct() {    
    $name = mysqli_real_escape_string(getConnection(), $_POST['name']);
    $price = mysqli_real_escape_string(getConnection(), $_POST['price']);
    $novelty = mysqli_real_escape_string(getConnection(), empty($_POST['novelty']) ? '0' : '1');
    $sale = mysqli_real_escape_string(getConnection(), empty($_POST['sale']) ? '0' : '1');
    $photo = mysqli_real_escape_string(getConnection(), basename($_FILES['photo']['name']));
    $categories = $_POST['categories'];    

    mysqli_query(getConnection(), "INSERT INTO `products` (`name`, `price`, `img`, `novelty`, `sale`) VALUES ('$name', '$price', '$photo', '$novelty', '$sale')");

    $id = mysqli_insert_id(getConnection());
    foreach ($categories as $category) {
        mysqli_query(getConnection(), "INSERT INTO `products_categories` (`products_id`, `categories_id`) VALUES ('$id', '$category')");
    }    
}

/**
 * Функция сохраняет изображение товара на сервер
 * @param int $sizeFilter максимльный размер сохраняемого файла
 * @param array $typeFilter тип файлов разрешенных для сохранения 
 */

function isLoadImgProduct($sizeFilter, $typeFilter) {
    if (!empty($_FILES['photo']['name'])) {        
        if ($_FILES['photo']['size'] <= $sizeFilter && in_array(mime_content_type($_FILES['photo']['tmp_name']), $typeFilter)) {
            move_uploaded_file($_FILES['photo']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/img/products/' . basename($_FILES['photo']['name']));
        }
    }
}

/**
 * Функция изменяет товар в БД 
 */
function isChangeProduct() {
    $id = mysqli_real_escape_string(getConnection(), $_POST['id']);
    $name = mysqli_real_escape_string(getConnection(), $_POST['name']);
    $price = mysqli_real_escape_string(getConnection(), $_POST['price']);
    $novelty = mysqli_real_escape_string(getConnection(), empty($_POST['novelty']) ? '0' : '1');
    $sale = mysqli_real_escape_string(getConnection(), empty($_POST['sale']) ? '0' : '1');
    $categories = $_POST['categories'];    

    $products = getProducts();
    foreach ($products as $item) {
        if ($item['id'] == $id) $product = $item;
    }

    if (empty($_FILES['photo']['name']) && !empty($product['img'])) {
        $photo = $product['img'];
    } else {
        $photo = basename($_FILES['photo']['name']);
    }
    
    $photo = mysqli_real_escape_string(getConnection(), $photo);
    
    $query = "UPDATE `products` 
            SET `name` = '$name', `price` = '$price', `novelty` = '$novelty', `sale` = '$sale', `img` = '$photo'
            WHERE `id` = '$id'";
    
    mysqli_query(getConnection(), $query);

    mysqli_query(getConnection(), "DELETE FROM `products_categories` WHERE `products_id` = '$id'");
    
    foreach ($categories as $category) {
        mysqli_query(getConnection(), "INSERT INTO `products_categories` (`products_id`, `categories_id`) VALUES ('$id', '$category')");
    }    
}


/**
 * Функция добавляет заказ в БД 
 * @param array настройки формирования стоимости заказа с учетом доставки
 */
function isAddOrder(array $deliveryPrice) {
    $prodId = mysqli_real_escape_string(getConnection(), $_POST['prodId']);
    $surname = mysqli_real_escape_string(getConnection(), $_POST['surname']); 
    $name = mysqli_real_escape_string(getConnection(), $_POST['name']);
    $thirdName = mysqli_real_escape_string(getConnection(), isset($_POST['thirdName']) ? $_POST['thirdName'] : '');
    $phone = mysqli_real_escape_string(getConnection(), $_POST['phone']);
    $email = mysqli_real_escape_string(getConnection(), $_POST['email']);
    $delivery = mysqli_real_escape_string(getConnection(), $_POST['delivery']);
    $city = mysqli_real_escape_string(getConnection(), isset($_POST['city']) ? $_POST['city'] : '');
    $street = mysqli_real_escape_string(getConnection(), isset($_POST['street']) ? $_POST['street'] : '');
    $home = mysqli_real_escape_string(getConnection(), isset($_POST['home']) ? $_POST['home'] : '');
    $aprt = mysqli_real_escape_string(getConnection(), isset($_POST['aprt']) ? $_POST['aprt'] : '');
    $pay = mysqli_real_escape_string(getConnection(), $_POST['pay']);
    $comment = mysqli_real_escape_string(getConnection(), isset($_POST['comment']) ? $_POST['comment'] : '');

    $res = mysqli_fetch_assoc(mysqli_query(getConnection(), "SELECT `price` FROM `products` WHERE `id` = '$prodId'"));
    $cost = $res['price'];

    if ($delivery == 1 && $cost < $deliveryPrice['free']) {
        $cost = $cost + $deliveryPrice['standart'];
    }
    
    $sql = "INSERT INTO `orders` (`products_id`, `cost`, `surname`, `name`, `thirdName`, `phone`, `email`, `delivery`, `city`, `street`, `home`, `aprt`, `pay`,`comment`) VALUES ('$prodId', '$cost', '$surname', '$name', '$thirdName', '$phone', '$email', '$delivery', '$city', '$street', '$home', '$aprt', '$pay', '$comment')";
    
    mysqli_query(getConnection(), $sql);
}

/**
 * Функция получает данные всех заказов из БД
 * @return array список заказов
 */
function getOrders(): array
{
    $result = mysqli_query(getConnection(), "
        SELECT * FROM `orders`
    ");

    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $orders;
}


/**
 * Меняет статус заказа с не выполненного на выполненный и наоборот
 * @param int $id - id заказа
 * @param int $status - статус заказа
 */
function isChangeOrderStatus(int $id, int $status) {
    $id = mysqli_real_escape_string(getConnection(), $id);
    $status = mysqli_real_escape_string(getConnection(), $status);
    
    mysqli_query(getConnection(), "UPDATE `orders` SET `status`='$status' WHERE `id` = '$id'");
}
