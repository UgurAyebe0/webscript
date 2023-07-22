<?php
include_once('system/system.php'); 
ob_start();
$_SESSION['login'] = '';
$_SESSION['kid'] = '';
$_SESSION['uuid'] = '';
$_SESSION['username'] = '';
header('Location:'.$domain2);
?>