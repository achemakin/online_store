<?php
session_name('session_id');
ini_set('session.gc_maxlifetime', 60*20);
ini_set('session.cookie_lifetime', 60*20);
session_set_cookie_params(60*20);

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/lib/lib.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/helper.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/bd.php';
