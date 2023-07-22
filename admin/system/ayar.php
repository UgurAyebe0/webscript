<?php 
	@session_start();
	ob_start();
	
	## Hataları Gizle ##
	// error_reporting(0);
	 
	## Bağlantı Değişkenleri ##
	$host 	=	"87.248.157.101";
	$user 	=	"candycra_site";
	$pass 	=	"pw9ND4pZXY4o@!";
	$db		=	"kpanel";
	
	## Mysql Bağlantısı ##
	$baglan = mysql_connect($host, $user, $pass) or die (mysql_Error());
	
	## Veritabanı Seçimi ##
	mysql_select_db($db, $baglan) or die (mysql_Error());
	

	## Karakter Sorunu ##
	mysql_query("SET CHARACTER SET 'utf8'");
	mysql_query("SET NAMES 'utf8'");
	 
	 
	 
	  

?>