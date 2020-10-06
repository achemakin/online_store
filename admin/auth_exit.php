<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';
    session_destroy();
    header ('Location: /admin/');