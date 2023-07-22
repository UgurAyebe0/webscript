<?php 
	@session_start();
	ob_start();
	
	## Hataları Gizle ##
	error_reporting(0);
	 
	## Bağlantı Değişkenleri ##
	$hostse 	=	"87.248.157.101:3306";
	$userse 	=	"candycra_site";
	$passse 	=	"pw9ND4pZXY4o@!";
	$dbiki		=	"BungeeCord";
	
	## Mysql Bağlantısı ## 
	$baglaniki = mysql_connect($hostse, $userse, $passse) or die (mysql_Error());
	
	## Veritabanı Seçimi ## 
	mysql_select_db($dbiki, $baglaniki) or die (mysql_Error());
	

	## Karakter Sorunu ##
	mysql_query("SET CHARACTER SET 'utf8'");
	mysql_query("SET NAMES 'utf8'");
	 
	  

?>