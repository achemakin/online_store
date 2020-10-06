<?php
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

$inputLogin = '';
$inputPassword = '';
$authErr = false;
$adminErr = false;

if (isset($_COOKIE['login'])) {
    $inputLogin = filterInputText($_COOKIE['login']);
}

if (isset($_POST['login'])) {
    $inputLogin = filterInputText($_POST['login']);
    $inputPassword = filterInputText($_POST['password']);  

    $getUser = getUserByEmail($inputLogin);

    if ($getUser && password_verify($inputPassword, $getUser['password'])) {        
        $_SESSION['auth'] = true;
        $_SESSION['admin'] = false;
        $_SESSION['operator'] = false; 
        
        foreach($getUser['groupsId'] as $group) {
            if ($group == '1') $_SESSION['admin'] = true;
            if ($group == '2') $_SESSION['operator'] = true;
        }             
       
        setcookie('login', $getUser['email'], time() + 3600 * 24 * 30, '/');
    } else {
        $authErr = true;
    }
}

if (isAuth()) {
    if (isAdmin() || isOperator()) {
        header ('Location: /orders/');
    } else {
        $adminErr = true; 
    }    
}

showHeader($userMenu);
?>

<main class="page-authorization">
  <h1 class="h h--1"><?=getTitleArrayThroughPath($userMenu)?></h1>
  <form class="custom-form" action="/admin/" method="post">
    <?php 
    if ($authErr): ?>
        <strong>Неправильный логин или пароль!</strong>
    <?php elseif($adminErr): ?>
        <strong>Пользователь не является администратором или оператором!</strong>
    <?php endif; ?>
    
    <input type="email" class="custom-form__input" name="login" value="<?=$inputLogin?>" required="">
    <input type="password" class="custom-form__input" name="password" value="<?=$inputPassword?>" required="">
    <button class="button" type="submit">Войти в личный кабинет</button>
  </form>
</main>

<?php
showFooter($userMenu);
?>