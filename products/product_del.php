<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';

isAdmin(true);

if (isset($_GET['id'])) {
    isActiveUpdate($_GET['id']);
}
