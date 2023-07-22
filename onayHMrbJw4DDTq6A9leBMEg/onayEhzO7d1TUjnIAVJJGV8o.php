<?php
include ("../config.php");
error_reporting(E_ALL);
$guvenlik="03a5003a5c147582cac31b7d8527"; // Mağaza panelinde size verilen güvenlik kodunuz.
$merchant_id=$_POST["merchant_id"]; // Mağaza numaranız  geri gönderilir
$merchant_key=$_POST["merchant_key"]; // Mağaza key post ile gönderilir , yukarıdaki key ile karşılaştırınız.
$user_ip=$_POST["user_ip"]; // Ödemeyi yapan kişinin ip adresi gönderilir
$return_id=$_POST["return_id"]; // yorum alanı,yazdığınız return_id geri gönderilir.
$pay_id=$_POST["pay_id"]; // Ödeme kanalı 1:Mobil Ödeme,2:Kredi Kartı,3:Banka Havalesi,5:Sonteklif Elektronik Kod (veriler sayı olarak gelir (1,2,3,5)
$pay_amount=$_POST["pay_amount"]; // Ödeme tutarı
$product_id=$_POST["product_id"]; // Satın alınan ürün numarası.
$gsm=$_POST["gsm"]; // Satın alan müşterinin GSM numarası veya kullandığı elektronik kod.
$order_id=$_POST["order_id"]; // Maxepin'de kayıtlı sipariş numarası // siparişin tekrarlanmasını engellemek için kullanılabilir.
$return_id2=$_POST["return_id2"]; //  Ürün eklerken yazdığınız sayısal değer, ep,coins yüklemeleri için kullanılabilir.


if ( $guvenlik == $merchant_key)
{
	$kredi=mysql_query("UPDATE Kullanicilar SET Kredi = Kredi+".$return_id2." WHERE username = '$return_id'");
	
$kacangetirsqel = mysql_fetch_array(mysql_query("SELECT * FROM Kullanicilar WHERE username='$return_id'"));
$KullaniciId=$kacangetirsqel["KullaniciId"];


	$krediyukelemelog=mysql_query("INSERT INTO KrediYuklemeLog ( KullaniciId, OdemeIp, OdemeKanali, OdemeTutari, UrunNumarasi, Telefon, SiparisNumarasi, VerilenTutar) VALUES ('$KullaniciId', '$user_ip', '$pay_id', '$pay_amount', '$product_id', '$gsm', '$order_id', '$return_id2')");
	$kredimiktari=mysql_query("SELECT Kredi FROM Kullanicilar WHERE KullaniciId='$KullaniciId'");
	$yenikredi=$kredimiktari[0]+$return_id2;
	$kredilog=mysql_query("INSERT INTO KrediLog ( KullaniciId, EskiKredi, YeniKredi, Ip, Detay, Aciklama) VALUES ('$KullaniciId', '$kredimiktari[0]', '$yenikredi', '$user_ip', '1' ,'Kredi Yükleme.')");
	if ($kredi) {
		echo "OK";
	}
	else {
		echo "Hata var.";
	}
}
?>