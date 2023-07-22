<?php 
require_once('../system/system.php'); 
ob_start();
if($_SESSION['yonetici'] != ''){
	unset($_SESSION['yonetici']);
	unset($_SESSION['grup']);

	header('Location: /webpanel/login.php');
}
?>
