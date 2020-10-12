<?php

/* количество отображаемых на странице товаров */
const NUM_PROD_PAGE = 9;

/* тип загружаемых файлов */
const TYPE_FILE = array('image/png', 'image/jpeg', 'image/jpg');


/* максимальный размер загружаемых файлов (Mb) */
const SIZE_FILE = 5*1024*1024;

/* Насторойти базы двнных */
const BD_HOST = 'localhost';
const BD_LOGIN = 'root';
const BD_PASSWORD = 'root';
const BD_NAME = 'prod';


/* Стоимость доставки */
$deliveryPrice = [
    'standart' => 280,
    'free' => 2000,
    'day' => 560,
    'Moscow' => 280
];
