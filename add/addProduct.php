<?php
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

isAdmin(true);

if (isset($_POST['name'])) {
    if(isset($_POST['id'])) {
        isChangeProduct();
    } else {
        isAddProduct();        
    }
    
    isLoadImgProduct($sizeFilter, $typeFilter);
}
