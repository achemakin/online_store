<?php

/* количество отображаемых на странице товаров */
$numberProductsPage = 9;

// тип загружаемых файлов
$typeFilter = ['image/png', 'image/jpeg', 'image/jpg'];

//максимальный размер загружаемых файлов (Mb)
$sizeFilter = 5*1024*1024;

/* Пункты основного меню */
$userMenu = [
    [
        'title' => 'Главная',
        'path' => '/',
        'namePage' => 'Fashion'
    ],
    [
        'title' => 'Новинки',
        'path' => '/novelty/',
        'namePage' => 'Fashion'
    ],
    [
        'title' => 'Sale',
        'path' => '/sale/',
        'namePage' => 'Fashion'
    ],
    [
        'title' => 'Доставка',
        'path' => '/delivery/',
        'namePage' => 'Доставка'
    ],
    [
        'title' => '',
        'path' => '/admin/',
        'namePage' => 'Авторизация'
    ]
];

/* Пункты меню для оператора и администратора */
$adminMenu = [
    [
        'title' => 'Главная',
        'path' => '/'
    ],
    [
        'title' => 'Товары',
        'path' => '/products/',
        'namePage' => 'Товары'
    ],
    [
        'title' => 'Заказы',
        'path' => '/orders/',
        'namePage' => 'Список заказов'
    ],
    [
        'title' => 'Выйти',
        'path' => '/admin/auth_exit.php'
    ],
    [
        'title' => '',
        'path' => '/add/',
        'namePage' => 'Добавление товара'
    ]
];

/* Стоимость доставки */
$deliveryPrice = [
    'standart' => 280,
    'free' => 2000,
    'day' => 560,
    'Moscow' => 280
];
