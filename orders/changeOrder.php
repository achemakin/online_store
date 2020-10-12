<?php
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/start.php';


if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_GET['status'])) $status = $_GET['status'];

isChangeOrderStatus($id, $status);
